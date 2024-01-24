import React from 'react'
import {redirect} from 'next/navigation'
import PrismaOrm from '@/lib/prismaOrm'

import { IntialProfileSetup } from '@/lib/intialProfileSetup'
import { CreateServerModal } from '@/components/Modals/CreateServerModal'

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
    return redirect(`/servers/${server.uuid}`)
 }

 return <CreateServerModal />

  return (
    <div className="container mb-20">
      <div className="mb-20 row">
        Create Server<br />
        Create Server<br />
        Create Server<br />
        Create Server<br />
        Create Server<br />
      </div>
    </div>
  )
}

export default SetupPage