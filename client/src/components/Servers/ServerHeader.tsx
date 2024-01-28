"use client"

import { Server } from "@prisma/client"

interface ServerHeaderProps {
    server: Server
}

const ServerHeader = ({server}: ServerHeaderProps) => {
    
    //const   server = Server.fromProps(serverHeaderProps)

    return (
        <div>ServerHeader</div>
    )
}

export default ServerHeader