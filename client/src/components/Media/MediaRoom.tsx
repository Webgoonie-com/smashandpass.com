"use client";

import { useEffect, useState } from "react";
//import { LiveKitRoom, VideoConference } from "@livekit/components-react";
//import "@livekit/components-styles";
import { Channel } from "@prisma/client";
import { IntialProfileSetup } from '@/lib/intialProfileSetup'
import getCurrentUser from "@/actions/getCurrentUsers";
import { Loader2 } from "lucide-react";

interface MediaRoomProps {
    chatId: string;
    video: boolean;
    audio: boolean;
  };

  export const MediaRoom = async ({
    chatId,
    video,
    audio
  }: MediaRoomProps) => {
    
    const user = await getCurrentUser()
    
    
    console.log('Line 24 = user', user);

    const [token, setToken] = useState("");

    useEffect(() => {
        if (!user?.name) return;
    
        const name = `${user.name}`;

        console.log('Line 33 = name', name);
    
        (async () => {
          try {
            const resp = await fetch(`/api/livekit?room=${chatId}&username=${name}`);
            const data = await resp.json();
            setToken(data.token);
          } catch (e) {
            console.log(e);
          }
        })()
      }, [user?.name, chatId]);

      if (token === "") {
        return (
          <div className="flex flex-col flex-1 justify-center items-center">
            <Loader2
              className="h-7 w-7 text-zinc-500 animate-spin my-4"
            />
            <p className="text-xs text-zinc-500 dark:text-zinc-400">
              Loading...
            </p>
          </div>
        )
      }

      return (
        <>
            {/* <LiveKitRoom
              data-lk-theme="default"
              serverUrl={process.env.NEXT_PUBLIC_LIVEKIT_URL}
              token={token}
              connect={true}
              video={video}
              audio={audio}
            >
              <VideoConference />
            </LiveKitRoom> */}
            Live Kit
        </>
      )
  }

