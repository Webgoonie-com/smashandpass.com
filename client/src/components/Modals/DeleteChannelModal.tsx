"use client";

import qs from "query-string";
import axios from "axios";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"


import { useModal } from "@/Hooks/useModalStore"
import { Button } from "@/components/ui/button"
import { useRouter } from "next/navigation";
import { useState } from "react"




export const DeleteChannelModal = () => {

    
    const [isLoading, setIsLoading] = useState(false)

    const router = useRouter();
    
    const {isOpen, onClose, type, data } = useModal()

    

    const isModalOpen = isOpen && type === "deleteChannel"

    const {server, channel } = data
    
    const onClick = async () => {
        try {
            
            setIsLoading(true);

            const url = qs.stringifyUrl({
              url: `/api/channels/${channel?.Id}`,
              query: {
                serverId: server?.uuid,
      
              }
            })
      
            await axios.delete(url);
      
            router.refresh();
            onClose();

            //router.push(`/servers/${server?.uuid}`);

          } catch (error) {

            console.log(error);

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
                        Delete This Channel?
                    </DialogTitle>
                    <DialogDescription className="text-center text-zinc-500">
                        Are you sure you want to delete this channel? <br />
                        <span
                            className="font-semibold text-orange-500"
                        > #{channel?.name} </span><br />
                        Will be forever deleted this action is permanent.
                    </DialogDescription>
                </DialogHeader>
                {/* Start Body Content */}
                

                <DialogFooter
                    className="bg-gray-300 px-6 py-4"
                >
                    <div className="flex items-center justify-between w-full">
                        <Button
                            disabled={isLoading}
                            onClick={onClose}
                            className=""
                            variant={"ghost"}
                        >
                            Cancel
                        </Button>
                        <Button
                            disabled={isLoading}
                            onClick={onClick}
                            className=""
                            variant={"primary"}
                        >
                            Confirm
                        </Button>
                    </div>
                </DialogFooter>
              
              
                {/* End Body Content */}
            </DialogContent>
        </Dialog>
    );
}
 
