"use client"

import { ServerWithMembersWithProfiles } from "@/Types"
import { MemberRole } from "@prisma/client"
import { DropdownMenuTrigger, DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator } from "@/components/ui/dropdown-menu"
import { ChevronDown, LogOut, PlusCircle, Settings, Trash, UserPlus, Users } from "lucide-react"
import { useModal } from "@/Hooks/useModalStore"


interface ServerHeaderProps {
    server: ServerWithMembersWithProfiles
    role?:  MemberRole
}

const ServerHeader = ({server, role}: ServerHeaderProps) => {

    const { onOpen } = useModal()

    const isAdmin = role === MemberRole.ADMIN
    const isModerator = isAdmin || role === MemberRole.MODERATOR
    

    return (
        <div>
            <DropdownMenu>
                <DropdownMenuTrigger
                className="focus:outline-none" asChild>
                    <button
                        className="w-full text-md font-semibold px-3 flex items-center h-12 border-neutral-200
                        dark:border-neutral-800 border-b-2 hover:bg-zinc-700/10
                        dark:hover:bg-zinc-700/500 transition
                        "
                    >
                        {server.name}
                        <ChevronDown className="h-5 w-5 ml-auto" />
                    </button>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    className="w-56 text-sx font-medium text-black dark:text-neutral-400 space-y-[2px]"
                >
                    {isModerator && 
                    (
                        <DropdownMenuItem
                            onClick={() => onOpen("invite", {server})}
                            className="text-orange-800 dark:text-orange-400 px-3 py-2 text-sm cursor-pointer"
                        >
                            Invite People
                            <UserPlus className="h-4 w-4 ml-auto" />
                        </DropdownMenuItem>
                    )}
                    {isAdmin && 
                    (
                        <DropdownMenuItem
                            onClick={() => onOpen("editServer", {server})}
                            className="px-3 py-2 text-sm cursor-pointer"
                        >
                            Edit Server Settings
                            <Settings className="h-4 w-4 ml-auto" />
                        </DropdownMenuItem>
                    )}
                    {isAdmin && 
                    (
                        <DropdownMenuItem
                        onClick={() => onOpen("members", {server})}
                            className="px-3 py-2 text-sm cursor-pointer"
                        >
                            Manage Members
                            <Users  className="h-4 w-4 ml-auto" />
                        </DropdownMenuItem>
                    )}
                    {isModerator && 
                    (
                        <DropdownMenuItem
                            onClick={() => onOpen("createChannel")}
                            className="px-3 py-2 text-sm cursor-pointer"
                        >
                            Create Channel
                            <PlusCircle  className="h-4 w-4 ml-auto" />
                        </DropdownMenuItem>
                    )}
                    {isModerator && 
                    (
                        <DropdownMenuSeparator />
                    )}
                    {isAdmin && 
                    (
                        <DropdownMenuItem
                        onClick={() => onOpen("deleteServer", {server})}
                            className="text-rose-500 px-3 py-2 text-sm cursor-pointer"
                        >
                            Delete Server
                            <Trash  className="h-4 w-4 ml-auto" />
                        </DropdownMenuItem>
                    )}
                    {!isAdmin && 
                    (
                        <DropdownMenuItem
                            onClick={() => onOpen("leaveServer", {server})}
                            className="text-rose-500 px-3 py-2 text-sm cursor-pointer"
                        >
                            Leave Server
                            <LogOut  className="h-4 w-4 ml-auto" />
                        </DropdownMenuItem>
                    )}
                </DropdownMenuContent>
            </DropdownMenu>
            

        </div>
    )
}

export default ServerHeader