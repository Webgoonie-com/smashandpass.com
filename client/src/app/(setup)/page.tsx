

import React from 'react'
import { redirect } from 'next/navigation'
import { PrismaOrm } from '@/lib/prismaOrm'

import { IntialProfileSetup } from '@/lib/intialProfileSetup'
import { IntialModal } from '@/components/Modals/IntialModal'


const SetupPage = async () => {

    const profile = await IntialProfileSetup()

    if(!profile){
        return null;
    }
    

    const server = await PrismaOrm.server.findFirst({
        where: {
            members: {
                some: {
                    profileId: profile?.Id,
                }
            }
        }
    })


    if(server){
        console.log(`'We have a server lets redirect to: ' /servers/${server.uuid}`)
        return redirect(`/servers/${server.uuid}`)
    }

    // Create Server
    return <IntialModal  />

}

export default SetupPage