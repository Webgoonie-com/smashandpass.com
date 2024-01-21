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
                profileId: profile?.Id as number,
            }
        }
    }
 })

 if(server){
    return redirect
 }

  return (
    <div className=''>Create Server</div>
  )
}

export default SetupPage