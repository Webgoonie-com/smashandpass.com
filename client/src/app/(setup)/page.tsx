import React from 'react'
import {redirect} from 'next/navigation'
import PrismaOrm from '@/lib/prismaOrm'

import { IntialProfileSetup } from '@/lib/intialProfileSetup'

const SetupPage = async () => {
 const profile = await IntialProfileSetup()

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
    return redirect(`/server/${server.Id}`)
 }

  return (
    <div className=''>Create Server</div>
  )
}

export default SetupPage