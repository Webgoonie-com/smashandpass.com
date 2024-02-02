import { ChatHeader } from '@/components/ChatComps/ChatHeader';
import { CurrentProfile } from '@/lib/currentProfile';
import PrismaOrm from '@/lib/prismaOrm';
import { redirect } from 'next/navigation';
import React from 'react'
import { string } from 'zod'

interface ChannelIdProps {
  params:{
    serverId: string;
    channelId: string;
  }
}
const ChannelIdPage = async ({params}: ChannelIdProps) => {

  
  const profile = await CurrentProfile()

    if(!profile) return redirect('/')

  const channel = await PrismaOrm.channel.findUnique({
    where: {
      Id: parseInt(params.channelId),
    },
  });

  const server = await PrismaOrm.server.findFirst({
    where:{
      uuid: params.serverId,
    }
  })

   
    if (!server) {
      redirect("/");
      return null; 
    }

  const member = await PrismaOrm.member.findFirst({
    where: {
      serverId: server?.Id,
      profileId: profile.Id,
    }
  });

    if (!channel || !member) {
      redirect("/");
      return null; 
    }


  return (
    <div className='mt-[74px] flex h-full z-30 flex-col top-0 absolute inset-y-0'>

          <div className='font-semibold'>
            <div className="bg-white dark:bg-[#313338] flex flex-col h-full">
              <ChatHeader
                name={channel.name}
                serverId={channel.serverId}
                type="channel"
              />
              Channel Id Page
            </div>
          </div>
      
      </div>
  )
}

export default ChannelIdPage;