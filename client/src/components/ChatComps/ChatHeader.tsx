import { Hash } from "lucide-react";

import { MobileToggle } from "@/components/MobileToggle";
import  UserAvatar from "@/components/UserAvatar";
import {PrismaOrm} from "@/lib/prismaOrm";
import { redirect } from "next/navigation";
//import { SocketIndicator } from "@/components/socket-indicator";

//import { ChatVideoButton } from "./chat-video-button";

interface ChatHeaderProps {
  serverId: number;
  name: string;
  type: "channel" | "conversation";
  imageUrl?: string;
}

export const ChatHeader = async ({
  serverId,
  name,
  type,
  imageUrl
}: ChatHeaderProps) => {

 

  const server = await PrismaOrm.server.findFirst({
    where:{
      uuid: serverId.toString(),
    }
  })

   
    if (!server) {
      redirect("/");
      return null; 
    }

  return (
    

    <div className="text-md font-semibold px-3 flex items-center h-12 border-neutral-200 dark:border-neutral-800 border-b-2">
      <MobileToggle 
        serverId={server.uuid} 
      />
      {type === "channel" && (
        <Hash className="w-5 h-5 text-zinc-500 dark:text-zinc-400 mr-2" />
      )}
      {type === "conversation" && (
        <UserAvatar 
          src={imageUrl}
          className="h-8 w-8 md:h-8 md:w-8 mr-2"
        />
      )}
      <p className="font-semibold text-md text-black dark:text-white">
        {name}
      </p>
      
    </div>
  )
}