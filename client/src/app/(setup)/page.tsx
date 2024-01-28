"use server"

import React from 'react'
import {redirect} from 'next/navigation'
import PrismaOrm from '@/lib/prismaOrm'

import { IntialProfileSetup } from '@/lib/intialProfileSetup'
import { CreateServerModal } from '@/components/Modals/CreateServerModal'
import { revalidatePath } from 'next/cache'

const SetupPage = async () => {

 const profile = await IntialProfileSetup()

if(!profile){
  
  revalidatePath('/test') // Update cached posts
  redirect(`/test`)
  return
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
    return redirect(`/servers/${server.uuid}`)
 }

 return <CreateServerModal  />

}

export default SetupPage