import { useEffect } from "react";
import { useQueryClient } from "@tanstack/react-query";
import { useSocket } from "@/Providers/SocketProvider";
import { Member, Message, Profile } from "@prisma/client";
import { AiOutlineConsoleSql } from "react-icons/ai";

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
      
        console.log('Line 32 useChatSocket.ts : Socket?', socket)

        // No socket no need to do anything just return
        if (!socket) {
            console.log("Sorry There's not Socket")
            return;
        }else{
            console.log("Yes We Have A Socket")
        }

        // socketMethod to update the message in real time, delete or edit it.-mx-1
        socket.on(updateKey, (message: MessageWithMemberWithProfile) =>{
            
            console.log('Line 46 Found updatekey on UseSeocket')

            queryClient.setQueryData([queryKey], (oldData: any) => {
                if(!oldData || !oldData.pages || oldData.pages.length === 0){
                    console.log('!oldData || !oldData.pages || oldData.pages.length', !oldData || !oldData.pages || oldData.pages.length)
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

                console.log('Line 66 useSocketTs. NewData: ', newData)

                    return {
                        ...oldData,
                        pages: newData,
                    }
                })

            });

            // Another Socket Watching For New fetchMessages
            socket.on(addKey, (message: MessageWithMemberWithProfile) => {
                
                console.log('Line 79 Found Addkey on UseSeocket')
                queryClient.setQueryData([queryKey], (oldData: any) => {
                    if(!oldData || !oldData.pages || oldData.pages.length === 0) {
                        return {
                            pages: [{
                                items: [message],
                            }]
                        }
                    }

                    const newData = [...oldData.pages]

                    newData[0] = {
                        ...newData[0],
                        items: [
                            message,
                            ...newData[0].items,
                        ]
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