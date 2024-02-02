import React from 'react'


import { Separator } from "@/components/ui/separator"
import { ScrollArea } from "@/components/ui/scroll-area"
import {NavigationAction} from './navigationAction'
import { NavigationItem } from './NavigationItem'
import { ModeToggle } from '../modeToggle'
import { CurrentProfile } from '@/lib/currentProfile'
import { redirect } from 'next/navigation'
import PrismaOrm from '@/lib/prismaOrm'
import LogOutButton from '@/components/LogOutButton'


export const SideBarNav = async () => {
    const profile = await CurrentProfile()

    if(!profile){
        return redirect("/test")
    }

    const servers = await PrismaOrm.server.findMany({
        where: {
            members: {
                some: {
                    profileId: profile.Id
                }
            }
        }
    })



    return (
        <div 
            className="
                space-y-4 flex flex-col items-center h-full
                text-primary w-full dark:bg-[#1E1F22] bg-[#E3E5E8] py-3
            "
        >

            

            <NavigationAction />

            <Separator 
                className="h-[2px] bg-slate-500 dark:bg-zinc-500 rounded-md w=10 mx-auto" 
            />

            <ScrollArea className="w-full flex-1">
                {servers.map((server) => (
                    <div key={server.Id} className='mb-4'>
                       <NavigationItem 
                            Id={server.Id} 
                            uuid={server.uuid} 
                            imageUrl={server.imageUrl} 
                            name={server.name}                       />
                    </div>
                ))}
            </ScrollArea>

            <div className="pb-10 mt-auto flex items-center flex-col gap-y-4">
            
                <ModeToggle />

                <LogOutButton />
                
            </div>

            <Separator />

        </div>
    )
}
