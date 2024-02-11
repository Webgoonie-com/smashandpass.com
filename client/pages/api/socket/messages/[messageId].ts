import { NextApiResponseServerIo } from "@/Types";
import { NextApiRequest, NextApiResponse } from "next";
import  { PrismaOrm }  from "@/lib/prismaOrm"
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

        const {messageId, serverId, channelId, profileId} = req.query;

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
        if(!channelId){
            return res.status(404).json({error: "channeId Is Missing"});
        }
        if(!serverId){
            return res.status(404).json({error: "serverId Is Missing"});
        }
        if(!messageId){
            return res.status(404).json({error: "messageId Is Missing"});
        }

        const server = await PrismaOrm.server.findFirst({
            where: {
              Id: parseInt(serverId as string),
              //uuid: serverId as string,
              members: {
                some: {
                  profileId: parseInt(profileId as string),
                }
              }
            },
            include: {
              members: true,
            }
        })
    
        if (!server) {
        return res.status(404).json({ error: "Server not found" });
        }

        const channel = await PrismaOrm.channel.findFirst({
        where: {
            Id: parseInt(channelId as string),
            serverId: parseInt(serverId as string),
        },
        });
    
        if (!channel) {
        return res.status(404).json({ error: "Channel not found" });
        }
    
        const member = server.members.find((member) => member.profileId === parseInt(profileId as string));
    
        if (!member) {
        return res.status(404).json({ error: "Member not found" });
        }
    
        let message = await PrismaOrm.message.findFirst({
        where: {
            Id: parseInt(messageId as string),
            channelId: parseInt(channelId as string),
        },
        include: {
            member: {
            include: {
                profile: true,
            }
            }
        }
        })

        if (!message || message.deleted) {
            return res.status(404).json({ error: "Message not found" });
        }


        const isMessageOwner = message.memberId === member.Id;
        const isAdmin = member.role === MemberRole.ADMIN;
        const isModerator = member.role === MemberRole.MODERATOR;
        const canModify = isMessageOwner || isAdmin || isModerator;

        if (!canModify) {
            return res.status(401).json({ error: "Unauthorized to modify" });
        }

        if(req.method==="DELETE") {


            message = await PrismaOrm.message.update({
                where: {
                  Id: parseInt(messageId as string),
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
      
            message = await PrismaOrm.message.update({
              where: {
                Id: parseInt(messageId as string),
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

        const updateKey = `chat:${channelId}:messages:update`;
  
        res?.socket?.server?.io?.emit(updateKey, message);

        return res.status(200).json(message);
        
    }catch(error){
        console.log('[MESSAGE_ID]', error)
        return res.status(500).json({error: "Internal Error" })
    }
}