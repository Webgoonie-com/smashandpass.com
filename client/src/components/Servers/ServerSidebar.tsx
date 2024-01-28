import { ChannelType } from '@prisma/client';
import { CurrentProfile } from '@/lib/currentProfile'
import PrismaOrm from '@/lib/prismaOrm';
import { redirect } from 'next/navigation';
import React from 'react'
import ServerHeader from './ServerHeader';

interface ServerSidebarProps
{
    serverId: string
}

const ServerSidebar = async({serverId}: ServerSidebarProps) => {

    const profile = await CurrentProfile();

    if(!profile){
        return redirect('/login')
    }

    const server = await PrismaOrm.server.findUnique({
        where:{
            uuid: serverId,
        },
        include:{
            channels:{
                orderBy:{
                    createdAt: "asc"
                }
            },
            members: {
                include: {
                    profile: true
                },
                orderBy: {
                    role: "asc"
                }
            }
        }
    })


    const textChannels = server?.channels.filter((channel) => channel.type === ChannelType.TEXT)
    const audioChannels = server?.channels.filter((channel) => channel.type === ChannelType.AUDIO)
    const videoChannels = server?.channels.filter((channel) => channel.type === ChannelType.VIDEO)

    // This one removes ourselves from the list of members.
    const members = server?.members.filter((member) => member.profileId !== profile.Id)

    if(!server){
        redirect("/")
    }

    const role = server.members.find((member) => member.profileId===profile.Id)?.role

    return (
        <div className="flex flex-col h-full text-primary w-full dark:bg-[#2B2D31] bg-[#F2F3F5]">
           <ServerHeader
            server={server}
            role={role}
            />
        </div>
    )
}

export default ServerSidebar