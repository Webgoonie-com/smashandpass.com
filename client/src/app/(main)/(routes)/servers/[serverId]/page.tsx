

import { CurrentProfile } from '@/lib/currentProfile'
import {PrismaOrm} from '@/lib/prismaOrm'
import { redirect } from 'next/navigation'



interface ServerIdProps {
  params: {
    serverId: string
  }
}
const ServerIdPage = async ({params}: ServerIdProps) => {

  const profile = await CurrentProfile()

  if(!profile) {
    console.log('Redirecting From Main becasue no profile found.')
    return redirect('/')
  }

  const server = await PrismaOrm.server.findUnique({
    where: {
      uuid: params.serverId,
      members: {
        some: {
          profileId: profile.Id,
        }
      }
    },
    include: {
      channels: {
        where: {
          name: "lobby"
        },
        orderBy: {
          createdAt: "asc"
        }
      }
    }
  })

  // console.log(' server results', server)

  const initialChannel = server?.channels[0];

  if (initialChannel?.name !== "lobby") {
    console.log('Returning Null No Initial channel')
    return null;
  }

  //console.log('Line 53 server results ${params.serverId}: ', params.serverId)
  //console.log('Line 53 server results {initialChannel?.Id}: ', initialChannel?.Id)

  return redirect(`/servers/${params.serverId}/channels/${initialChannel?.uuid}`)

  
}

export default ServerIdPage