import { NextApiRequest, NextApiResponse } from 'next'
import { getSession } from "next-auth/react"
import { NextApiResponseServerIo } from '@/Types'
import { PrismaOrm } from '@/lib/prismaOrm';



console.log('Hitting pages/api/messages.ts')

export default async function handler(
  req: NextApiRequest, 
  res: NextApiResponseServerIo,
) {
    console.log('Messages.ts req.method: ', req.method)
    
  if (req.method !== 'POST') {
    return res.status(405).json({ error: "Method not allowed" });
  }

  try {

    console.log('Trying to get session')

    
    
    const {content, fileUrl} = req.body;
    
    console.log('req.query', req.query)
    console.log('req.query', req.body)

    const {serverId, channelId, profileId } = req.query;


    console.log('req.query', profileId)

    if (!profileId) {
      return res.status(401).json({ error: "Unauthorized" });
    }

    // Now you can use the session object
    

    const profile = await PrismaOrm.user.findUnique({
        where: {
            id: parseInt(profileId as string),
        }
    })

    console.log("Line 49 = profile", profile, "profile.uuid: ", profile?.uuid);

    if(!profile){
        console.log("Line 45 = !profileDetected")
        return null
    }


    if(!serverId){
        console.log("Line 51 = !serverId Missing")
        return null
    }

    if(!channelId){
        console.log("Line 56 = !channeId Missing")
        return null
    }

    if(!content){
        console.log("Line 61 = !content Missing")
        return null
    }

    if(!fileUrl){
        console.log("Line 61 = !fileUrl Missing")
    }
    
    const server = await PrismaOrm.server.findFirst({
        where:{
            Id: parseInt(serverId as string),
            members:{
                some:{
                    profileId: profile.id
                }
            }
        },
        include: {
            members: true,
        }
    })

    if(!server){
        return res.status(404).json({ meessage: "Server not found"})
    }

    const channel = await PrismaOrm.channel.findFirst({
        where:{
            Id: parseInt(channelId as string),
            serverId: parseInt(serverId as string),
        }
    })

    if(!channel){
        return res.status(404).json({ meessage: "Channel not found"})
    }

    // Now Find Member

    const member =  server.members.find((member) => member.profileId === profile.id);
    
    console.log('Member: ', member)

    if(!member){
        return res.status(404).json({ meessage: "member not found"})
    }

    //Finally let's create the message after all the above security checks and arranging members on profiles for servers and channnels

    const message = await PrismaOrm.message.create({
        data: {
          content: content,
          fileUrl,
          channelId: parseInt(channelId as string),
          memberId: member.Id as number,
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
        const channelKey = `chat:${channelId}:messages`;
        console.log('channelKey for socket: ', channelKey)

        res?.socket?.server?.io?.emit(channelKey, message);
    
        return res.status(200).json(message)

    //const member = server.members.find((member) => member.profileId === profileId);

    // Rest of your code


  } catch (error) {
    console.error("[ERROR]", error);
    return res.status(500).json({ error: "Internal Server Error" });
  }
}
