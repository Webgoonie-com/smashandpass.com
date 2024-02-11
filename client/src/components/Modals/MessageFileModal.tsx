'use client'

import axios from "axios";
import qs from "query-string";
import * as z from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm, useFormContext } from "react-hook-form";
import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";

import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";

import {
    Form,
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage
} from "@/components/ui/form";

import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import  FileUpload  from "../../components/Forms/FileUpload";
import { useModal } from "@/Hooks/useModalStore";
import AttachmentUpload from "../Forms/AttachmentUpload";



const formSchema = z.object({
    
        fileUrl: z.string().min(1, {
        message: "Attachment is required."
    })
});


export const MessageFileModal = () => {

   
    
    const { isOpen, onClose, type, data } = useModal();

    //console.log('Line 51 MessageFileModal: ', data)

    const router = useRouter()

    const isModalOpen = isOpen && type === "messageFile";

    const { apiUrl, query } = data;

    

    const form = useForm({
        resolver: zodResolver(formSchema),
        defaultValues: {
            
            fileUrl: "",
        }
    })

    const handleClose = () => {
        form.reset();
        onClose();
    }

    const isLoading = form.formState.isSubmitting

    const onSubmit = async (values: z.infer<typeof formSchema>) => {
        console.log(values)
        try {

            //  console.log('apiUrl: ', apiUrl)

            const url = qs.stringifyUrl({
                url: apiUrl || "",
                query,
            });

            if(!apiUrl || !query){

                return null
        
            }

            console.log('ready for response...')

            await axios.post(url, {
                ...values,
                serverId: query.serverId,
                channelId: query.channelId,
                content: values.fileUrl,
            });


            
            form.reset()
            router.refresh()
            handleClose()
            
        } catch (error) {
            console.log('Error',    )
        }
    }

     


   
    
    return (
        <Dialog open={isModalOpen}  onOpenChange={handleClose}>
            <DialogContent className="bg-white text-black p-0 overflow-hidden">
                <DialogHeader className="pt-8 px-6">
                    <DialogTitle className="text-center text-2xl font-extrabold">
                        Prepare A File Attachment
                    </DialogTitle>
                    <DialogDescription className="text-center text-neutral-500">
                        Send a file as a message
                    </DialogDescription>
                </DialogHeader>
                {/* Start Body Content */}

                <Form {...form}>
                    <form className="space-y-8" onSubmit={form.handleSubmit(onSubmit)}>
                        <div className="space-y-8 px-6">
                            <div className="flex items-center justify-center text-center">

                                <FormField
                                control={form.control}
                                name="fileUrl"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormControl>
                                            <AttachmentUpload
                                                endpoint="messageFile"
                                                value={field.value}
                                                onChange={field.onChange}
                                            />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                                />
                            </div>

                           
                        </div>
                        {/* Start Dialog Footer Within Body And Form */}
                        <DialogFooter className="bg-gray-100 px-6 py-4">
                            <Button variant={"primary"} disabled={isLoading}>
                                Send
                            </Button>
                        </DialogFooter>
                        {/* End Dialog Footer */}
                    </form>
                </Form>
              
              
                {/* End Body Content */}
            </DialogContent>
        </Dialog>
    );
}
 
