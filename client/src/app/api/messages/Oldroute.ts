import { authOptions } from "@/lib/auth";
import NextAuth from "next-auth/next";
import { NextApiRequest, NextApiResponse } from 'next'
import { NextApiResponseServerIo } from '@/Types'
import { CurrentProfile } from '@/lib/currentProfile'
import { NextResponse } from "next/server";
import { PrismaOrm } from "@/lib/prismaOrm";
import { Server } from "socket.io"

async function SocketHandler(
    req: Request, 
    res: NextApiResponseServerIo
) {
    //  console.log('SocketHandler Hit! req', req)
    //  console.log('SocketHandler Hit! res', res)

    if (req.method !== 'POST') {
      console.log("Not Post");
      return NextResponse.json({ error: "Method Not allowed" });
    }
    
    const body = await req.json()
    const url = await req.url
    
    //  console.log('url', url)

    //  console.log('body', body)

    const {
        content, fileUrl, serverId, channelId 
    } = body

    

   

    try {
        

        const profile = await CurrentProfile()

        const { searchParams } = new URL(req.url);

        const cursor = searchParams.get("cursor")
        //const channelId = searchParams.get("channel") 

        //  console.log('Line 25 Message Route currentProfile: ', profile)

        //  console.log('req.body', req.body)
        //  const { content, fileUrl, serverId, channelId } = req.body;

        //  console.log('Line 29 Message', content)
        //  console.log('Line 29 Message serverId', serverId)
        //  console.log('Line 29 Message channelId', channelId)
        //  console.log('Line 30 Message', fileUrl)

        

        if (!profile) {
            console.log("Profile Id No")
            return NextResponse.json({ error: "Unauthorized" });
        }    
        
        if (!serverId) {
            console.log("Server Id No")
            return NextResponse.json({ error: "Server ID missing" });
        }
            
        if (!channelId) {
            console.log("Channel Id No")
            return NextResponse.json({ error: "Channel ID missing" });
        }
                
        if (!content) {
            return NextResponse.json({ error: "Content missing" });
        }

        //  console.log('Made it Thru')

        const server = await PrismaOrm.server.findFirst({
            where: { 
                Id: serverId as number,
                members: {
                    some: {
                        profileId: profile.Id as number
                    }
                }

            },
            include:{
                members: true,
            }
        })

        if(!server){
            return NextResponse.json({ error: "Server on mmessage route" });
        }

        const channel = await PrismaOrm.channel.findFirst({
            where: {
              Id: channelId as number,
              serverId: serverId as number,
            }
          });
      
          if (!channel) {
            return NextResponse.json({ error: "Channel not found" });
          }

          const member = server.members.find((member) => member.profileId === profile.Id);

          if (!member) {
            //return res.status(404).json({ message: "Member not found" });
            return NextResponse.json({ error: "Member not found" });
          }
      
          const message = await PrismaOrm.message.create({
            data: {
              content: content,
              fileUrl,
              channelId: channelId as number,
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
          

            const channelKey = `chat:${channelId}:messages`;
            //  console.log('channelKey: ', channelKey)

          
            res?.socket?.server?.io?.emit(channelKey, message);

            return NextResponse.json(message);
          
          

        

    } catch (error) {
        console.log("[MESSAGS_POST]", error)

        return NextResponse.json({ message: "Internal Error" });
    }
}

export { SocketHandler as GET, SocketHandler as POST }
