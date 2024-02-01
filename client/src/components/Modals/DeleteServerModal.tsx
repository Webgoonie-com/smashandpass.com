'use client'

import axios from "axios"
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




export const DeleteServerModal = () => {

    
    const [isLoading, setIsLoading] = useState(false)
    const router = useRouter();

    const {isOpen, onClose, type, data } = useModal()

    

    const isModalOpen = isOpen && type === "deleteServer"

    const {server } = data
    
    const onClick = async () => {
        try {
          setIsLoading(true);
    
          await axios.delete(`/api/servers/${server?.uuid}`);
    
          onClose();
          router.refresh();
          router.push("/");
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
                        Delete This Server
                    </DialogTitle>
                    <DialogDescription className="text-center text-zinc-500">
                        Are you sure you want to delete this server? <br />
                        <span
                            className="font-semibold text-orange-500"
                        >{server?.name}</span>
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
 
