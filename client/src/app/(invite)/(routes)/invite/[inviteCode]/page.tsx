import { CurrentProfile } from '@/lib/currentProfile'
import PrismaOrm from '@/lib/prismaOrm'
import { redirect } from 'next/navigation'
import React from 'react'

interface InviteCodePageProps{
    params:{
        inviteCode: string
    }
}
const InviteCodePage = async ({params}: InviteCodePageProps) => {

    const profile = await CurrentProfile()

    if(!profile){
        return redirect("/login")
    }

    if(!params.inviteCode || !profile){
        return redirect("/")
    }

    const exisitingServer = await PrismaOrm.server.findFirst({
        where:{
            inviteCode: params.inviteCode,
            members:{
                some:{
                    profileId: profile.Id
                }
            }
        }
    })

    if(exisitingServer){
        return redirect(`/servers/${exisitingServer.Id}`)
    }

    const server = await PrismaOrm.server.update({
        where:{
            inviteCode: params.inviteCode,
        },
        data: {
            members: {
                create: [
                    {
                        profileId: profile.Id
                    }
                ]
            }
        }
    })


    return (
        <div>InviteCodePage</div>
    )
}

export default InviteCodePage