'use client'

import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"


import { useModal } from "@/Hooks/useModalStore"
import { Label } from "@/components/ui/label"
import { Input } from "@/components/ui/input"
import { Button } from "@/components/ui/button"
import { Check, Copy, RefreshCcw } from "lucide-react"

import { useOrigin } from "@/Hooks/useOrigin"
import { useState } from "react"
import axios from "axios"


console.log('InviteModal running')
export const InviteModal = () => {

    const [copied, setCopied ] = useState(false);
    const [isLoading, setIsLoading] = useState(false)

    const {onOpen, isOpen, onClose, type, data } = useModal()

    const origin = useOrigin()

    const isModalOpen = isOpen && type === "invite"

    const {server } = data
    
    const inviteUrl = `${origin}/invite/${server?.inviteCode}`
    
    const onCopy = () => {
        navigator.clipboard.writeText(inviteUrl)
        setCopied(true)
    }

    setTimeout(() => {
        setCopied(false)
    }, 3500);


    const onNew = async () => {
        try {
            setIsLoading(true)
            const response =  await axios.patch(`/api/servers/${server?.uuid}/invite-code`)

            onOpen("invite", {server: response.data})
        } catch (error) {
            console.log('error', error)
        } finally {
            setIsLoading(false);
        }
    }

    
    



    
    return (
        <Dialog
            open={isModalOpen}
            onOpenChange={onClose}
        >
            <DialogContent className="bg-white text-black p-0 overflow-hidden">
                <DialogHeader className="pt-8 px-6">
                    <DialogTitle className="text-center text-2xl font-extrabold">
                        Please Invite Friends
                    </DialogTitle>
                </DialogHeader>
                {/* Start Body Content */}
                

                <div className="p-6">
                    <Label className="uppercase text-sx font-bold text-zinc-500 dark:text-secondary/70">Server Invite Link</Label>
                    <div className="flex items-center mt-2  gap-x-2">
                       
                        <Input 
                            disabled={isLoading}
                            className="bg-zinc-300/50 border-0 focus-visible-ring-0 text-black focus-visible:ring-offset-0"
                            value={inviteUrl}
                        />
                        <Button 
                            disabled={isLoading} 
                            size={"icon"} 
                            onClick={onCopy}>
                            {copied ? <Check className="w-4- h-4 text-green-600" /> : <Copy className="w-4- h-4 text-zinc-400" />}
                        </Button>
                    </div>
                    <Button onClick={onNew} disabled={isLoading} variant={"link"} size={"sm"} className="text-xs text-zinc-500 mt-5">
                        Generate A New Link
                        <RefreshCcw className="w-4 h-4 ml-3"/>
                    </Button>
                    
                </div>
              
              
                {/* End Body Content */}
            </DialogContent>
        </Dialog>
    );
}
 
