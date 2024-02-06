import { NextApiRequest } from "next";

import { NextApiResponseServerIo } from "@/Types";
import { CurrentProfilePages } from "@/lib/currentProfilePages";
import { PrismaOrm } from "@/lib/prismaOrm";

console.log('Hit socket/messages/index.ts')

export default async function handler(
  req: NextApiRequest,
  res: NextApiResponseServerIo,
) {
  if (req.method !== "POST") {
    return res.status(405).json({ error: "Method not allowed" });
  }

  try {
    
    const profile = await CurrentProfilePages(req);
    console.log('Profile on index.ts under pages/api/socket/messages/index.ts', profile)
    const { content, fileUrl } = req.body;
    const { serverId, channelId } = req.query;
    
    if (!profile) {
      return res.status(401).json({ error: "Unauthorized" });
    }    
  
    if (!serverId) {
      return res.status(400).json({ error: "Server ID missing" });
    }
      
    if (!channelId) {
      return res.status(400).json({ error: "Channel ID missing" });
    }
          
    if (!content) {
      return res.status(400).json({ error: "Content missing" });
    }

    const server = await PrismaOrm.server.findFirst({
      where: {
        Id: parseInt(serverId as string),
        members: {
          some: {
            profileId: profile.Id
          }
        }
      },
      include: {
        members: true,
      }
    });

    if (!server) {
      return res.status(404).json({ message: "Server not found" });
    }

    const channel = await PrismaOrm.channel.findFirst({
      where: {
        Id: parseInt(channelId as string),
        serverId: parseInt(serverId as string),
      }
    });

    if (!channel) {
      return res.status(404).json({ message: "Channel not found" });
    }

    const member = server.members.find((member: { profileId: number; }) => member.profileId === profile.Id);

    if (!member) {
      return res.status(404).json({ message: "Member not found" });
    }

    const message = await PrismaOrm.message.create({
      data: {
        content,
        fileUrl,
        channelId: parseInt(channelId as string),
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

    const channelKey = `chat:${channelId}:messages`;

    res?.socket?.server?.io?.emit(channelKey, message);

    return res.status(200).json(message);
  } catch (error) {
    console.log("[MESSAGES_POST]", error);
    return res.status(500).json({ message: "Internal Error" }); 
  }
}