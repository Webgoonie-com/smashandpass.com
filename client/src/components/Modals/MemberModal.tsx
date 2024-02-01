"use client"

import qs from "query-string";
import axios from "axios"

import { useState } from "react"
import { useRouter } from "next/navigation";

import { MemberRole } from "@prisma/client";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"


import { useModal } from "@/Hooks/useModalStore"

import { format, formatDistance, formatRelative, subDays } from 'date-fns'
import { daysInYear } from "date-fns/constants";

import { ServerWithMembersWithProfiles } from "@/Types"
import { ScrollArea } from "@/components/ui/scroll-area"
import UserAvatar from "@/components/UserAvatar"
import { Check, Copy, RefreshCcw, Gavel, Loader2, MoreVertical, Shield, ShieldAlert, ShieldCheck, ShieldQuestion, ShieldCloseIcon} from "lucide-react"
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuPortal,
    DropdownMenuSeparator,
    DropdownMenuSub,
    DropdownMenuSubContent,
    DropdownMenuTrigger,
    DropdownMenuSubTrigger,
  } from "@/components/ui/dropdown-menu";



const roleIconMap = {
    "GUEST": null,
    "MODERATOR": <ShieldCheck className="h-4 w-4 ml-2 text-indigo-500" />,
    "ADMIN": <ShieldAlert className="h-4 w-4 text-rose-500" />
}

export const MemberModal = () => {

    const [loadingId, setLoadingId] = useState<number | string>();

    const {onOpen, isOpen, onClose, type, data } = useModal()

    const router = useRouter();

    const isModalOpen = isOpen && type === "members"

    const { server } = data as { server: ServerWithMembersWithProfiles}
    
    const onKick = async (memberId: string) => {
        try {
          setLoadingId(memberId);
          const url = qs.stringifyUrl({
            url: `/api/members/${memberId}`,
            query: {
              serverId: server?.Id,
            },
          });
    
          const response = await axios.delete(url);
    
          router.refresh();
          onOpen("members", { server: response.data });
        } catch (error) {
          console.log(error);
        } finally {
          setLoadingId("");
        }
      }
    
    
       

    const onRoleChange = async (memberId: number, role: MemberRole) => {
        try {
            setLoadingId((memberId))

            const url = qs.stringifyUrl({
                url: `/api/members/${memberId}`,
                query: {
                  serverId: server?.Id,
                  
                }
            });

            const response = await axios.patch(url, {role})

            router.refresh();
            onOpen("members", { server: response.data })

        } catch (error) {
            console.log('Error', error)
        } finally {
            setLoadingId("")
        }
    }

    

    
    return (
        <Dialog
            open={isModalOpen}
            onOpenChange={onClose}
        >
            <DialogContent className="bg-white text-black overflow-hidden">
                <DialogHeader className="pt-8 px-6">
                    <DialogTitle className="text-center text-2xl font-extrabold">
                        Manage Members
                    </DialogTitle>
                    <DialogDescription
                        className="text-center text-zinc-600"
                    >
                        {server?.members?.length} Members Active
                    </DialogDescription>
                </DialogHeader>
                {/* Start Body Content */}
                

                <ScrollArea
                    className="mt-8 max-h-[420px] pr-6"
                >
                    {server?.members?.map((member) => (
                        <div key={member.Id} className="flex items-center gap-x-2 p-2 mb-6">
                            <UserAvatar src={member?.profile?.imageUrl} />
                            <div
                                className="flex flex-col gap-y-1"
                            >
                                <div className="text-xs font-semibold flex items-center gap-x-1">
                                    {member.profile.name}
                                    {roleIconMap[member.role]}
                                </div>
                               
                                <p className="text-xs">
                                    Since: {format(new Date(member.profile?.createdAt), "LLL yyyy ")}
                                    </p>
                            </div>
                            {server.profileId !== member.profileId && loadingId !== member.Id && (
                                <div className="ml-auto">
                                    <DropdownMenu>
                                        
                                        <DropdownMenuTrigger>
                                            <MoreVertical className="h-4 w-4 text-zinc-500" />
                                        </DropdownMenuTrigger>

                                        <DropdownMenuContent side={"left"}>
                                            
                                            <DropdownMenuSub>
                                                
                                                <DropdownMenuSubTrigger className="flex items-center">
                                                    <ShieldQuestion className="w-4 h-4 mr-2" />
                                                    <span>Role</span>
                                                </DropdownMenuSubTrigger>

                                                <DropdownMenuPortal>
                                                    <DropdownMenuSubContent>
                                                        <DropdownMenuItem 
                                                            onClick={() => onRoleChange(member.Id, "GUEST")}
                                                        >
                                                            <Shield className="h-4 w-4 mr-2" />
                                                            Guest
                                                            {member.role === "GUEST" && (
                                                                <Check className="h-4 w-4 ml-auto" />
                                                            )}
                                                        </DropdownMenuItem>
                                                        <DropdownMenuItem
                                                            onClick={() => onRoleChange(member.Id, "MODERATOR")}
                                                        >
                                                            <ShieldCheck className="h-4 w-4 mr-2" />
                                                            Moderator
                                                            {member.role === "MODERATOR" && (
                                                                <Check className="h-4 w-4 ml-auto" />
                                                            )}
                                                        </DropdownMenuItem>
                                                    </DropdownMenuSubContent>
                                                </DropdownMenuPortal>

                                            </DropdownMenuSub>

                                            <DropdownMenuSeparator />

                                            <DropdownMenuItem
                                                onClick={() => onKick(member.Id.toLocaleString())}
                                            >
                                                <Gavel className="h-4 w-4 mr-2" />
                                                Kick
                                            </DropdownMenuItem>

                                            

                                        </DropdownMenuContent>

                                    </DropdownMenu>
                                </div>
                            )}
                            {loadingId === member.Id && (
                                <Loader2 className="animate-spin text-orange-200 ml-auto w-4- h-4" />
                            )}
                        </div>
                    ))}
                </ScrollArea>
              
              
                {/* End Body Content */}
            </DialogContent>
        </Dialog>
    );
}
 
