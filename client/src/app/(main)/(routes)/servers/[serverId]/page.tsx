

import { CurrentProfile } from '@/lib/currentProfile'
import PrismaOrm from '@/lib/prismaOrm'
import { redirect } from 'next/navigation'



interface ServerIdProps {
  params: {
    serverId: string
  }
}
const ServerIdPage = async ({params}: ServerIdProps) => {

  const profile = await CurrentProfile()

  if(!profile) return redirect('/')

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
          name: "general"
        },
        orderBy: {
          createdAt: "asc"
        }
      }
    }
  })

  const initialChannel = server?.channels[0];

  if (initialChannel?.name !== "general") {
    return null;
  }


  return redirect(`/servers/${params.serverId}/channels/${initialChannel?.Id}`)

  
}

export default ServerIdPage