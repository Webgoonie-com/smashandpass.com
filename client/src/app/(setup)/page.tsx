"use server"

import React from 'react'
import {redirect} from 'next/navigation'
import {PrismaOrm} from '@/lib/prismaOrm'

import { IntialProfileSetup } from '@/lib/intialProfileSetup'
import { IntialModal } from '@/components/Modals/IntialModal'
import { revalidatePath } from 'next/cache'

const SetupPage = async () => {

    const profile = await IntialProfileSetup()

    console.log('IntialProfileSetup', profile)

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
        console.log(`'We have a server lets redirect' /servers/${server.uuid}`)
        return redirect(`/servers/${server.uuid}`)
    }

    return <IntialModal  />

}

export default SetupPage