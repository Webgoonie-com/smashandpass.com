import { NextApiRequest, NextApiResponse } from "next";
import { MemberRole } from "@prisma/client";

import { getServerSession } from '@/lib/auth';

import { NextApiResponseServerIo } from "@/Types";
import { CurrentProfilePages } from "@/lib/currentProfilePages";
import { PrismaOrm } from "@/lib/prismaOrm";
import { NextResponse } from "next/server";

//console.log('Hit Outside Message Id')



export default async function handler(
  req: NextApiRequest,
  res: NextApiResponseServerIo
) {

  if (req.method === "PATCH") {
    //console.log('Hit PATCH');







    try { 
      //console.log('Line 245 req: ',)
  
      //Skipping Session Checking
      //const profile = await CurrentProfilePages(req);
      const profile = true
      
      //console.log('Line 27 Profile: ', profile)
     
  
      const { messageId, serverId, channelId } = req.query;
      //  const { content, profileId } = req.body;
      const { data: { content }, profileId } = req.body;
  
      // console.log('body', req.body)
      // console.log('profileId: ', profileId)
  
      // console.log('Liine 21 req.query: ', req.query)
      // console.log('Line 22 content ', content)
  
      if (!profileId) {
        return res.status(401).json({ error: "Unauthorized" });
      }
  
      if (!serverId) {
        return res.status(400).json({ error: "Server ID missing" });
      }
  
      if (!channelId) {
        return res.status(400).json({ error: "Channel ID missing" });
      }
  
      const server = await PrismaOrm.server.findFirst({
        where: {
          Id: parseInt(serverId as string),
          //uuid: serverId as string,
          members: {
            some: {
              profileId: profileId,
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
  
      const member = server.members.find((member) => member.profileId === profileId);
  
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
        return res.status(401).json({ error: "Unauthorized" });
      }
  
      
  
      if (req.method === "PATCH") {
        if (!isMessageOwner) {
          return res.status(401).json({ error: "Unauthorized" });
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
  
      // this the update for the messages that relates to the socket.
      const updateKey = `chat:${channelId}:messages:update`;
  
      res?.socket?.server?.io?.emit(updateKey, message);

      return res.status(200).json(message);
    } catch (error) {
      console.log("[MESSAGE_ID]", error);
      return res.status(500).json({ error: "Internal Error" });
    }








    
  }

  if (req.method === "DELETE") {
    console.log('Hit DELETE');
    

    
    const { messageId, serverId, channelId } = req.query;

    // console.log('Liine 21 req.query: ', req.query)   

    const server = await PrismaOrm.server.findFirst({
      where: {
        Id: parseInt(serverId as string),
        //uuid: serverId as string,
        // members: {
        //   some: {
        //     profileId: profileId,
        //   }
        // }
      },
      include: {
        members: true,
      }
    })

    // this might be wrong only the server owner will be able to do this I belive.
    // need to get session from /page/api directory to verify session.  May have to resort to coookies on this one.
    // dangerous temporary fix.
    const profileId = server?.profileId


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
      console.log('No channel found')
      return res.status(404).json({ error: "Channel not found" });
    }

    const member = server.members.find((member) => member.profileId === profileId);

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
    

    res.status(200).json({ message: 'Hello from Next.js!' })
  }

  // Default response for unsupported methods
  res.status(200).json({ message: 'Hello DELETE from Next.js!' })
}