
import { ChannelType, MemberRole  } from '@prisma/client';
import { CurrentProfile } from '@/lib/currentProfile'
import { PrismaOrm } from '@/lib/prismaOrm';
import { redirect } from 'next/navigation';
import React from 'react'
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from "@/components/ui/separator";

import { Hash, Mic, ShieldAlert, ShieldCheck, Video } from "lucide-react";

import ServerHeader from '@/components/Servers/ServerHeader';
import { ServerSearch } from '@/components/Servers/ServerSearch';
import { ServerSection } from "./ServerSection";
import { ServerChannel } from "./ServerChannel";
import { ServerMember } from "./ServerMember";
interface ServerSidebarProps
{
    serverId: string
}

const iconMap = {
    [ChannelType.TEXT]: <Hash className="mr-2 h-4 w-4" />,
    [ChannelType.AUDIO]: <Mic className="mr-2 h-4 w-4" />,
    [ChannelType.VIDEO]: <Video className="mr-2 h-4 w-4" />
  };
  
  const roleIconMap = {
    [MemberRole.GUEST]: null,
    [MemberRole.MODERATOR]: <ShieldCheck className="h-4 w-4 mr-2 text-indigo-500" />,
    [MemberRole.ADMIN]: <ShieldAlert className="h-4 w-4 mr-2 text-rose-500" />
  }

const ServerSidebar = async({serverId}: ServerSidebarProps) => {

    const profile = await CurrentProfile();

    if(!profile){
        return redirect('/signin')
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
            <ScrollArea className="flex-1 px-3">
        <div className="mt-2">
          <ServerSearch
            data={[
              {
                label: "Text Channels",
                type: "channel",
                data: textChannels?.map((channel) => ({
                  Id: channel.Id,
                  name: channel.name,
                  icon: iconMap[channel.type],
                }))
              },
              {
                label: "Voice Channels",
                type: "channel",
                data: audioChannels?.map((channel) => ({
                  Id: channel.Id,
                  name: channel.name,
                  icon: iconMap[channel.type],
                }))
              },
              {
                label: "Video Channels",
                type: "channel",
                data: videoChannels?.map((channel) => ({
                  Id: channel.Id,
                  name: channel.name,
                  icon: iconMap[channel.type],
                }))
              },
              {
                label: "Members",
                type: "member",
                data: members?.map((member) => ({
                  Id: member.Id,
                  name: member.profile.name,
                  icon: roleIconMap[member.role],
                }))
              },
            ]}
          />
        </div>
        <Separator className="bg-zinc-200 dark:bg-zinc-700  rounded-md my-2" />
        {!!textChannels?.length && (
          <div className="mb-2">
            <ServerSection
              sectionType="channels"
              channelType={ChannelType.TEXT}
              role={role}
              label="Text Only Channels"
            />
            <div className="space-y-[2px]">
              {textChannels.map((channel) => (
                <ServerChannel
                  key={channel.Id}
                  channel={channel}
                  role={role}
                  server={server}
                />
              ))}
            </div>
          </div>
        )}
        {!!audioChannels?.length && (
          <div className="mb-2">
            <ServerSection
              sectionType="channels"
              channelType={ChannelType.AUDIO}
              role={role}
              label="Voice Only Channels"
            />
            <div className="space-y-[2px]">
              {audioChannels.map((channel) => (
                <ServerChannel
                  key={channel.Id}
                  channel={channel}
                  role={role}
                  server={server}
                />
              ))}
            </div>
          </div>
        )}
        {!!videoChannels?.length && (
          <div className="mb-2">
            <ServerSection
              sectionType="channels"
              channelType={ChannelType.VIDEO}
              role={role}
              label="Video Only Channels"
            />
            <div className="space-y-[2px]">
              {videoChannels.map((channel) => (
                <ServerChannel
                  key={channel.Id}
                  channel={channel}
                  role={role}
                  server={server}
                />
              ))}
            </div>
          </div>
        )}
        {!!members?.length && (
          <div className="mb-2">
            <ServerSection
              sectionType="members"
              role={role}
              label="Members"
              server={server}
            />
            <div className="space-y-[2px]">
              {members.map((member) => (
                <ServerMember
                  key={member.Id}
                  member={member}
                  server={server}
                />
              ))}
            </div>
          </div>
        )}
      </ScrollArea>
        </div>
    )
}

export default ServerSidebar