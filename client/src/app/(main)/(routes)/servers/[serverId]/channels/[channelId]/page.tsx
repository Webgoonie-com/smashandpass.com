import { ChatHeader } from '@/components/ChatComps/ChatHeader';
import ChatInput from '@/components/ChatComps/ChatInput';
import ChatMessages from '@/components/ChatComps/ChatMessages';
import { CurrentProfile } from '@/lib/currentProfile';
import { PrismaOrm } from '@/lib/prismaOrm';
import { redirect } from 'next/navigation';
import React from 'react'

import { ScrollArea } from "@/components/ui/scroll-area"


interface ChannelIdProps {
  params:{
    serverId: string;
    channelId: string;
  }
}
const ChannelIdPage = async ({params}: ChannelIdProps) => {

  
  const profile = await CurrentProfile()
  const profileId = profile?.Id

    


    if(!profile){ 
      return redirect('/')
    }

    const channel = await PrismaOrm.channel.findFirst({
      where: {
        uuid: params.channelId,
      },
    });

    
    const server = await PrismaOrm.server.findUnique({
      where:{
        uuid: params.serverId,
      }
    })

  
   
    if (!server) {
        redirect("/");
      return null; 
    }

    // console.log("Liine 51 on channelId-page.tsx serverId: ", server?.Id)
    // console.log("Line 52 on channelId-page.tsx profileId:", profile.Id)

    const member = await PrismaOrm.member.findFirst({
      where: {
        serverId: server?.Id,
        profileId: profile.Id,
      }
    });

  //console.log('member found', member);

  

    if (!channel || !member) {
      console.log('Line 66 Not found so re directing to /')
      redirect("/");
      return null; 
    }


    return (
        <div className='mt-[74px] flex md:w-full h-full z-30 flex-col top-0 absolute inset-y-0'>

            <div className='fixed md:w-[84%] h-[90%]'>

                <div className="bg-white dark:bg-[#313338] flex flex-col h-full">
                

                  <ChatHeader
                    name={channel.name}
                    serverId={channel.serverId as any}
                    type="channel"
                  />
                  
                  <ScrollArea className="h-7/8 w-[99%] rounded-md border p-4">
                    
                    <div
                      className="flex-1"
                    >
                      
                      <ChatMessages
                        member={member}
                        name={channel.name}
                        chatId={channel.Id}
                        profileId={profile.Id}
                        type="channel"
                        apiUrl="/api/messages"
                        socketUrl="/api/socket/messages"
                        socketQuery={{
                          channelId: channel.Id.toString(),
                          serverId: channel.serverId.toString(),
                          profileId: profile.Id.toString(),
                        }}
                        paramKey="channelId"
                        paramValue={channel.Id.toString()}

                      />
                      
                    </div>
                    
                    {/* <div
                      className="flex-1"
                    > 
                    
                      Channel Id Page

                    </div> */}
                
                  </ScrollArea>

                  <div className="bottom-0">
                    <ChatInput
                    name={channel.name}
                    type={"channel"}
                    apiUrl={"/api/socket/messages"}
                    //apiUrl={"/api/messages"}
                    query={{
                      channelId: channel.Id,
                      serverId: channel.serverId,
                      profileId: profileId,
                    }}
                    />
                  </div>
                
                </div>
              
            </div>
        
        </div>
    )
}

export default ChannelIdPage;