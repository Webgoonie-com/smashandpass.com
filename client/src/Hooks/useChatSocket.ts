import { useEffect } from "react";
import { useQueryClient } from "@tanstack/react-query";
import { useSocket } from "@/Providers/SocketProvider";
import { Member, Message, Profile } from "@prisma/client";

type ChatSocketProps = {
    addKey:     string;
    updateKey:  string;
    queryKey:   string;
}

type MessageWithMemberWithProfile = Message & {
    member: Member & {
      profile: Profile;
    }
}


export const useChatSocket = ({
    addKey,
    updateKey,
    queryKey
}: ChatSocketProps) => {


    const { socket } = useSocket();
    const queryClient = useQueryClient();


    useEffect(() => {
      
        console.log('Line 32 : Socket?', socket)

        // No socket no need to do anything just return
        if (!socket) {
            return;
        }

        // socketMethod to update the message in real time, delete or edit it.-mx-1
        socket.on(updateKey, (message: MessageWithMemberWithProfile) =>{
            queryClient.setQueryData([queryKey], (oldData: any) => {
                if(!oldData || !oldData.pages || oldData.pages.length === 0){
                    return oldData
                }

                const newData = oldData.pages.map((page: any) => {
                    return {
                        ...page,
                        items: page.items.map((item: MessageWithMemberWithProfile) => {
                          if(item.Id === message.Id) {
                            return message
                          }
                          return item
                        })
                    }
                })

                    return {
                        ...oldData,
                        pages: newData,
                    }
                })

            });

            // Another Socket Watching For New fetchMessages
            socket.on(addKey, (message: MessageWithMemberWithProfile) => {
                queryClient.setQueryData([queryKey], (oldData: any) => {
                    if(!oldData || !oldData.pages || oldData.pages.length === 0) {
                        return {
                            pages: [{
                                items: [message],
                            }]
                        }
                    }

                    const newData = [...oldData.pages]

                    newData[0]={
                        ...newData[0],
                        items: {
                            items: [
                                message,
                                ...newData[0].items,
                            ]
                        }
                    }

                    return {
                        ...oldData,
                        pages: newData,
                    }

                })
            })

            return () => {
                socket.off(addKey)
                socket.off(updateKey)
            }
      
    }, [addKey, queryClient, queryKey, socket, updateKey])
    


  
}