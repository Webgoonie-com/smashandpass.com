"use client"

import Image from "next/image"
import {useParams, useRouter}  from "next/navigation"
    import { fromJSON } from "postcss";
import { ActionTooltip } from "../actionTooltip";
import { cn } from "@/lib/utils";

interface NavigationItemProps {
    Id: number | [];
    uuid: string;
    imageUrl: string;
    name: string;
}

export const NavigationItem  = ({
    Id,
    uuid,
    imageUrl,
    name
}: NavigationItemProps) => {
    const params = useParams()
    const router = useRouter()

    const str ="public"
    
    const envImageUrl = process.env.NEXT_PUBLIC_IMAGE_URL; 

    const modifiedImageUrl = imageUrl?.replace('/public', '');
    
    const modifiedImageUrl2 = envImageUrl?.replace('/images', '');

    const ImageURL = modifiedImageUrl2+modifiedImageUrl;

    const onClick = () => {

        router.push(`/servers/${uuid}`)

    }

   

    return ( 
            <ActionTooltip 
                side="right"
                align="center"
                label={name}
            >
                <button
                    onClick={onClick}
                    className="group relative flex items-center"
                >
                    <div className={cn(
                        "absolute left-0 bg-primary rounded-r-full transition-all w-[4px] mt-2",
                        params?.serverId !== Id && "group-hover:[h-20px]",
                        params?.serverId === Id ? "[h-36px]" : "h-[8px]"
                        
                    )} />

                    <div className={cn(
                        "relative group flex mx-3 h-[48px] w-[48px] rounded-[24px] group-hover:rounded-[16px] transition-all overflow-hidden",
                        params?.serverId === Id && "bg-primary/10 text-primary rounded-[16px]"
                        )}>
                        <Image
                            fill
                            src={ImageURL}
                            alt="User Channel Image"
                            sizes="48px"
                            className="relative"
                            priority={true}
                        />
                    </div>
                </button>
            </ActionTooltip> 
    );
}