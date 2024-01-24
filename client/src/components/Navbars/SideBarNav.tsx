import { CurrentProfile } from '@/lib/currentProfile'
import PrismaOrm from '@/lib/prismaOrm'
import { redirect } from 'next/navigation'
import React from 'react'


import { Separator } from "@/components/ui/separator"
import {NavigationAction} from './navigationAction'


export const SideBarNav = async () => {
    const profile = await CurrentProfile()

    if(!profile){
        return redirect("/dashboard")
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
                text-primary w-full dark:bg-[#1E1F22]
            "
        >
            <Separator />

            

            <NavigationAction />

            <Separator />

        </div>
    )
}

