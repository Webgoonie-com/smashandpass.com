"use client"

import { ServerWithMembersWithProfiles } from "@/Types"
import { MemberRole } from "@prisma/client"

interface ServerHeaderProps {
    server: ServerWithMembersWithProfiles
    role?:  MemberRole
}

const ServerHeader = ({server, role}: ServerHeaderProps) => {
    
    //const   server = Server.fromProps(serverHeaderProps)

    return (
        <div>
            
            Server Header

        </div>
    )
}

export default ServerHeader