import React from 'react'

import { redirect } from "next/navigation";
import { CurrentProfile } from '@/lib/currentProfile';
import { getOrCreateConversation } from "@/lib/conversations";
import {PrismaOrm} from '@/lib/prismaOrm';
import { ChatHeader } from '@/components/ChatComps/ChatHeader';

interface MemberIdPageProps {
  params: {
    memberId: string;
    serverId: number;
  },
  searchParams: {
    video?: boolean;
  }
}

const MemberIdPage = async ({
  params,
  searchParams,
}: MemberIdPageProps) => {

    const profile = await CurrentProfile();

    if (!profile) {
      return redirect("/login");
    }

    //console.log('Line 32 params.serverId', params.serverId)

    const server = await PrismaOrm.server.findFirst({
      where:{
        uuid: params.serverId as any,
      }
    })
  
     
      if (!server) {
        
        console.log('Could not find server', params.serverId)

        redirect("/");
        return null; 
      }  

      //console.log(' serverId: ', server.Id)
      //console.log(' profileId: ', profile.Id)

    const currentMember = await PrismaOrm.member.findFirst({
      where: {
        serverId: server.Id,
        profileId: profile.Id,
      },
      include: {
        profile: true,
      },
    });
  
    if (!currentMember) {
      //console.log('Current Member not found Redirecting')
      return redirect("/");
      return null; 
    }
  
    //console.log('getOrCreateConversation currentMember.Id', currentMember.Id)
    //console.log('getOrCreateConversation params.memberId', params.memberId)

    const conversation = await getOrCreateConversation(currentMember.Id, params.memberId);
  
    //console.log('Line 73 = conversation: ', conversation);

    if (!conversation) {
      //console.log('No Conversation', params.serverId)
      return redirect(`/servers/${params.serverId}`);
      return null; 
    }

    //  This is to comparing both these members to see if it matches.
    const { memberOne, memberTwo } = conversation;

    // if it mataches we picking the opposite member
    // We use number one for ourselves if Id matches
    const otherMember = memberOne.profileId === profile.Id ? memberTwo : memberOne;


    return (
        <div className='mt-[74px] flex flex-row w-full h-full z-30 top-0 absolute inset-y-0'>
          <div className="relative md:w-[87%]">
            <div className="bg-white dark:bg-[#313338] w-full flex flex-col h-full">
  
              <ChatHeader
                imageUrl={otherMember.profile.imageUrl as any}
                name={otherMember.profile.name}
                serverId={params.serverId}
                type="conversation"
              />
  
                <div className='p-2'>
                  Member Id Page
                </div>
              </div>
          </div>
          </div>
      )
}

export default MemberIdPage