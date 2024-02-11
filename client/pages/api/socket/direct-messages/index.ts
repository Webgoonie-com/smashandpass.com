import { NextApiRequest } from 'next'
import { NextApiResponseServerIo } from '@/Types'
import { PrismaOrm } from '@/lib/prismaOrm';
import { MemberRole } from '@prisma/client';



console.log('Hitting Direct-Messages in pages/api/socket/direct-messages')

export default async function handler(
  req: NextApiRequest, 
  res: NextApiResponseServerIo,
) {
 
    
  if (req.method !== "POST") {
    return res.status(405).json({ error: "Method not allowed" });
  }

  try {

 
    
    
    
    const {content, fileUrl} = req.body;
 
    const {conversationId, directMessageId, profileId } = req.query;

    //const profileId = req.query.profileId;


 
    if (!profileId) {
      return res.status(401).json({ error: "Unauthorized" });
    }

    // Now you can use the session object
    

    const profile = await PrismaOrm.user.findUnique({
        where: {
            id: parseInt(profileId as string),
        }
    })


    if(!profile){
        console.log("Line 45 = !profile Detected")
        return null
    }


    if(!conversationId){
        console.log("Line 54 = !conversationId Missing")
        return null
    }

    if(!content){
        console.log("Line 61 = !content Missing")
        return null
    }

   
    // Now Find conversation
    const conversation = await PrismaOrm.conversation.findFirst({
      where: {
        Id: parseInt(conversationId  as string),
        OR: [
          {
            memberOne: {
              profileId: profile.id,
            }
          },
          {
            memberTwo: {
              profileId: profile.id,
            }
          }
        ]
      },
      include:{
        memberOne:{
          include:{
            profile: true
          }
        },
        memberTwo:{
          include:{
            profile: true
          }
        }
      }
    })

    if(!conversation){
      return res.status(404).json({message: "Conversation not found"})
    }

    // Now Find Member
    const member =  
      conversation.memberOne.profileId === profile.id ? conversation.memberOne : conversation.memberTwo;
    
    

    if(!member){
        return res.status(404).json({ meessage: "member not found"})
    }

   
    //Finally let's create the message after all the above security checks and arranging members on profiles for servers and channnels

    const message = await PrismaOrm.directMessage.create({
      data: {
        content,
        fileUrl,
        conversationId: parseInt(conversationId as string),
        memberId: member.Id,
      },
      include: {
        member: {
          include: {
            profile: true,
          }
        }
      }
    });



    

   
     // Note we could also check if channelId is a string or number at this point.
       
    // Rest of your code


   

    
    const channelKey = `chat:${conversationId}:messages`;

    res?.socket?.server?.io?.emit(channelKey, message);

    return res.status(200).json(message);


  } catch (error) {
    console.log("[DIRECT_MESSAGES_POST]", error);
    return res.status(500).json({ error: "Internal Direct Message Server Error" });
  }
}
