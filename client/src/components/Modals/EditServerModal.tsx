'use client'

import axios from "axios";
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
import  EditFileUpload  from "@/components/Forms/EditFileUpload";
import { useModal } from "@/Hooks/useModalStore";

const formSchema = z.object({
    name: z.string().min(1, {
    message: "Server name is required."
    }),
    imageUrl: z.string().min(1, {
    message: "Server image is required."
    })
});


export const EditServerModal = () => {

    const { isOpen, onClose, type, data } = useModal();

    const router = useRouter()

    const isModalOpen = isOpen && type === "editServer";

    const { server } = data

    const form = useForm({
        resolver: zodResolver(formSchema),
        defaultValues: {
            name: "",
            imageUrl: "",
        }
    })

    const isLoading = form.formState.isSubmitting

    const onSubmit = async (values: z.infer<typeof formSchema>) => {
        // console.log(values)

        try {

            await axios.patch(`/api/servers/${server?.uuid}`, values)

            form.reset();
            router.refresh();
            onClose();
            
        } catch (error) {
            console.log('Error',    )
        }
    }   

    const handleOnClose = () => {
        form.reset();
        onClose();
      }

      useEffect(() => {
        
        if(server && server.name && server.imageUrl){
            form.setValue("name", server.name)
            form.setValue("imageUrl", server.imageUrl)
        }
      }, [form, server])
      
    
    return (
        <Dialog
            open={isModalOpen}
            onOpenChange={handleOnClose}
        >
            <DialogContent className="bg-white text-black p-0 overflow-hidden">
                <DialogHeader className="pt-8 px-6">
                    <DialogTitle className="text-center text-2xl font-extrabold">
                        Please Edit Customize Your Server
                    </DialogTitle>
                    <DialogDescription className="text-center text-neutral-500">
                        Here is where you can set up you server, you can always change it later.
                    </DialogDescription>
                </DialogHeader>
                {/* Start Body Content */}

                <Form {...form}>
                    <form className="space-y-8" onSubmit={form.handleSubmit(onSubmit)}>
                        <div className="space-y-8 px-6">
                            <div className="flex items-center justify-center text-center">

                                <FormField
                                control={form.control}
                                name="imageUrl"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormControl>
                                            <EditFileUpload
                                                endpoint="serverImage"
                                                value={server?.imageUrl as string}
                                                data={data as any}
                                                onChange={field.onChange}
                                            />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                                />
                            </div>

                            <FormField
                                control={form.control}
                                name="name"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel
                                            className="uppercase text-xs font-bold text-zinc-500 dark:text-secondary/70"
                                        >
                                            Server name
                                        </FormLabel>
                                        <FormControl>
                                            <Input
                                                disabled={isLoading}
                                                className="bg-zinc-300/50 border-0 focus-visible:ring-0 text-black focus-visible:ring-offset-0"
                                                placeholder="Enter server name"
                                                {...field}
                                            />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />
                        </div>
                        {/* Start Dialog Footer Within Body And Form */}
                        <DialogFooter className="bg-gray-100 px-6 py-4">
                            <Button variant={"primary"} disabled={isLoading}>
                                Save
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
 
