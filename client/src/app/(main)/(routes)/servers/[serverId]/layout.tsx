import ServerSidebar from "@/components/Servers/ServerSidebar";
import { CurrentProfile } from "@/lib/currentProfile"
import { PrismaOrm } from "@/lib/prismaOrm";
import { redirect } from "next/navigation";


const ServerIdLayout = async ({
    children, params
    }: {
        children: React.ReactNode,
        params: {serverId: string}
    }) => {

    const profile = await CurrentProfile();

    if(!profile){
        redirect('/signin')
    }

    const server = await PrismaOrm.server.findUnique({
        where: {
            uuid: params.serverId,
            members: {
                some: {
                    profileId: profile.Id
                }
            }
        }
    })


    if(!server){
        return redirect('/')
    }
    
    return (
        <div className="h-full">
            <div 
                className="mt-[74px] hidden md:flex h-full w-60 z-20 
                flex-col fixed inset-y-0"
            >
                <ServerSidebar serverId={params?.serverId} />
            </div>
            <main className="relative h-full md:pl-60 pb-80">
                {children}
            </main>
        </div>
    )
}

export default ServerIdLayout