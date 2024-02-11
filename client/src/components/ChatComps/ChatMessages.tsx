"use client"

import { Member, Message, Profile } from '@prisma/client'
import { Fragment, useRef, ElementRef } from "react";
import { format } from "date-fns";
import { ChatWelcome } from '@/components/ChatComps/ChatWelcome'
import { useChatQuery } from '@/Hooks/useChatQuery'
import { Loader2, ServerCrash } from "lucide-react";
import { ChatItem } from './ChatItem';

const DATE_FORMAT = 'd MMM yyy, HH:mm:ss a';
const DATE_FORMAT2 = 'yyyy-MM-dd'

type MessageWithMemberWithProfile = Message & {
    member: Member & {
        profile: Profile
    }
}

interface ChatMessagesProps {
    name: string
    profileId: number,
    member: Member
    chatId: number
    apiUrl: string
    socketUrl: string
    socketQuery: Record<string, string>
    paramKey: "channelId" | "conversationId"
    paramValue: string
    type:   "channel" | "conversation"
}

const ChatMessages = ({
    name,
    profileId,
    member,
    chatId,
    apiUrl,
    socketUrl,
    socketQuery,
    paramKey,
    paramValue,
    type,
}: ChatMessagesProps) => {

    //console.log('profile on Chat Message', JSON.stringify(profileId))   << This works brings back profileId information.

    //const profileId = profileId;

    const queryKey = `chat:${chatId}`;
    const addKey = `chat:${chatId}:messages`;
    const updateKey = `chat:${chatId}:messages:update` 

    const chatRef = useRef<ElementRef<"div">>(null);
    const bottomRef = useRef<ElementRef<"div">>(null);

    const {
        data,
        fetchNextPage,
        hasNextPage,
        isFetchingNextPage,
        status,
    } = useChatQuery({
        queryKey,
        apiUrl,
        paramKey,
        paramValue,
    });

  

    if (status === "pending") {
        return (
          <div className="flex flex-col flex-1 justify-center items-center">
            <Loader2 className="h-7 w-7 text-zinc-500 animate-spin my-4" />
            <p className="text-xs text-zinc-500 dark:text-zinc-400">
              Loading channel messages...
            </p>
          </div>
        )
    }

    if (status === "error") {
        return (
          <div className="flex flex-col flex-1 justify-center items-center">
            <ServerCrash className="h-7 w-7 text-zinc-500 my-4" />
            <p className="text-xs text-zinc-500 dark:text-zinc-400">
              Sorry... Something went wrong!
            </p>
          </div>
        )
    }

    console.log('94 Messages data: ', data);

    return (
        <div className='flex-1 flex flex-col py-4 overflow-y-auto'>
             <div className="flex-1">


                <ChatWelcome
                    type={type}
                    name={name}
                />


                <div className="flex flex-col-reverse mt-auto">

                   

                    { data?.pages?.map((group, index) => (
                        <Fragment key={index}>
                            {group.items?.map((message: MessageWithMemberWithProfile) => (
                                <ChatItem
                                    key={message.uuid}
                                    Id={message.Id}
                                    profileId={profileId}
                                    currentMember={member}
                                    member={message.member} 
                                    content={message.content}
                                    fileUrl={message.fileUrl}
                                    deleted={message.deleted}
                                    timeStamp={format(new Date(message.createdAt), DATE_FORMAT)} 
                                    isUpdated={message.updatedAt !== message.createdAt} 
                                    socketUrl={socketUrl} 
                                    socketQuery={socketQuery}                                />
                            ))}
                        </Fragment>
                    ))}
                </div>
             </div>
        </div>
    )
}

export default ChatMessages