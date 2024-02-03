import { NextApiResponseServerIo } from '@/Types'
import { CurrentProfile } from '@/lib/currentProfile'
import { NextApiRequest } from 'next'
import React from 'react'

import { PrismaOrm } from '@/lib/prismaOrm'
import { MemberRole } from '@prisma/client'


export default async function handler (
    req: NextApiRequest,
    res: NextApiResponseServerIo,
) {
    
    if(req.method !== 'POST') {
        return res.status(405).json({ error: "Method Not Allowed" })
    }

    try {
        
        //const profile = await CurrentProfilePages()
        
        const profile = await CurrentProfile()


        //console.log('Profile from Current Profile Pages', profile)
        console.log('Profile2 from Current Profile2 Pages', profile)

        const { content, fileUrl} = req.body

        const { serverId, channelId} = req.query

        if(!profile){
            return res.status(404).json({ error: "User Profile not found so it's unAuthorized" })
        }

        if(!serverId){
            return res.status(404).json({ error: "Server Id not found so it's unAuthorized" })
        }

        if(!channelId){
            return res.status(404).json({ error: "channelId not found so it's unAuthorized" })
        }


        const server = await PrismaOrm.server.findFirst({
            where: { 
                Id: serverId as any,
                members:{
                    some:{
                        profileId: profile.Id
                    }
                }
            },
            include:{
                members: true
            }
        })


        if(!server){
            console.log("[MESSAGES_POST] Server not found: ",)
            return res.status(404).json({message: "Server Not Found"})
        }

        console.log('before channel serverId: ', serverId)
        console.log('before channel channelId: ', channelId)
        const channel = await PrismaOrm.channel.findFirst({
            where: {
                Id:  channelId as any,
                serverId: serverId as any,
            }

        })

        if(!channel){
            console.log("[MESSAGES_POST] Server not found: ",)
            return res.status(404).json({message: "Channel Not Found"})
        }

        const member = server.members.find((member) => member.profileId === profile.Id)

        if(!member){
            console.log("[MESSAGES_POST] Member not found: ",)
            return res.status(404).json({message: "member Not Found"})
        }

        const message = await PrismaOrm.message.create({
            data:{
                content,
                fileUrl,
                channelId: channelId as any,
                memberId: member.Id,
            },
            include:{
                member:{
                    include:{
                        profile: true,
                    }
                }
            }
        })


        const channelKey = `chat:${channelId}:messages`

        console.log('About to Emit', channelKey)
        
        res?.socket?.server?.io?.emit(channelKey, message)

        return res.status(200).json(message)

    } catch (error) {
        
        console.log("[MESSAGES_POST] OTHER: ", error)

        return res.status(500).json({ message: "Internal Error" })
    }

}

