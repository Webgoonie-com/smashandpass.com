import { NextApiResponseServerIo } from "@/Types";
import { NextApiRequest, NextApiResponse } from "next";
import { PrismaOrm } from "@/lib/prismaOrm";
import { MemberRole } from "@prisma/client";


export default async function handler(
    req: NextApiRequest,
    res: NextApiResponseServerIo
  ) {
  
    if (req.method !== "DELETE" && req.method !== "PATCH") {
        return res.status(405).json({error: "Method not allowed" });
    }

    try {
        // console.log('Line 16 [messageId] req.query', req.query);
        // console.log('Line 17 [messageId] req.body', req.body);

        const {directMessageId, conversationId, profileId} = req.query;

        const { data: { content } }  = req.body;
        //  const { data: { content }, profileId } = req.body;

        // console.log('Content on MesssageID profileId', profileId)
        // console.log('Content on MesssageID channeId', channelId)
        // console.log('Content on MesssageID serverId', serverId)
        // console.log('Content on MesssageID messageId', messageId)

        // console.log('Content on Messsage: ', content)

        if(!profileId){
            return res.status(404).json({error: "profileId Is Missing"});
        }

        const profile = await PrismaOrm.profile.findUnique({
          where: {
              Id: parseInt(profileId as string),
          }
        })

        if(!profile){
          return res.status(404).json({error: "profile Is Missing"});
        }


       
        if(!conversationId){
            return res.status(404).json({error: "conversationId Is Missing"});
        }
       
       const conversation = await PrismaOrm.conversation.findFirst({
        where: {
          Id: parseInt(conversationId as string),
          OR: [
            {
              memberOne: {
                profileId: profile.Id,
              }
            },
            {
              memberTwo: {
                profileId: profile.Id,
              }
            },
          ]
        },
        include:{
          memberOne: {
            include: {
              profile: true,
            }
          },
          memberTwo: {
            include: {
              profile: true,
            }
          }
        }
       })

       if (!conversation) {
        return res.status(404).json({ error: "Conversation not found" });
        }
    
        const member = conversation.memberOne.profileId === profile.Id  ? conversation.memberOne:  conversation.memberTwo;
        
        if (!member) {
          return res.status(404).json({ error: "Member not found" });
        }
    
        let directMessage = await PrismaOrm.directMessage.findFirst({
        where: {
            Id: parseInt(directMessageId as string),
            conversationId: parseInt(conversationId as string),
        },
        include: {
            member: {
            include: {
                profile: true,
            }
            }
        }
        })

        if (!directMessage || directMessage.deleted) {
            return res.status(404).json({ error: "Message not found" });
        }


        const isMessageOwner = directMessage.memberId === member.Id;
        const isAdmin = member.role === MemberRole.ADMIN;
        const isModerator = member.role === MemberRole.MODERATOR;
        const canModify = isMessageOwner || isAdmin || isModerator;

        if (!canModify) {
            return res.status(401).json({ error: "Unauthorized to modify" });
        }

        if(req.method==="DELETE") {


          directMessage = await PrismaOrm.directMessage.update({
                where: {
                  Id: parseInt(directMessageId as string),
                },
                data: {
                  fileUrl: null,
                  content: "This message has been deleted.",
                  deleted: true,
                },
                include: {
                  member: {
                    include: {
                      profile: true,
                    }
                  }
                }
              })


        }

        if (req.method === "PATCH") {
            if (!isMessageOwner) {
              return res.status(401).json({ error: "Unauthorized to Update Message not owner" });
            }
      
            directMessage = await PrismaOrm.directMessage.update({
              where: {
                Id: parseInt(directMessageId as string),
              },
              data: {
                content,
              },
              include: {
                member: {
                  include: {
                    profile: true,
                  }
                }
              }
            })
          }

        const updateKey = `chat:${conversation.Id}:messages:update`;
  
        res?.socket?.server?.io?.emit(updateKey, directMessage);

        return res.status(200).json(directMessage);
        
    }catch(error){
        console.log('[MESSAGE_ID]', error)
        return res.status(500).json({error: "Internal Error" })
    }
}