'use client'

import qs from "query-string";
import axios from "axios";
import * as z from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm, useFormContext } from "react-hook-form";
import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";

import {
  Dialog,
  DialogContent,
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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
  } from "@/components/ui/select"
import { useModal } from "@/Hooks/useModalStore";
import { ChannelType } from "@prisma/client";








const forbiddenNames = ["general", "api", "server", "channel", "member", "smashandpass", "smashandpass.com"];

const formSchema = z.object({
    name: z.string().min(1, {
    message: "Channel name is required."
    }).refine(
        name => !forbiddenNames.includes(name),
        {
            message: `This channel name cannot be used... Pleast try again.`
        }
    ),
    type: z.nativeEnum(ChannelType)
});


export const EditChannelModal = () => {

    const { isOpen, onClose, type, data } = useModal();

    const router = useRouter()

    const isModalOpen = isOpen && type === "editChannel";

    const { channel, server } = data

    const form = useForm({
        resolver: zodResolver(formSchema),
        defaultValues: {
            name: "",
            type: channel?.type || ChannelType.TEXT,
        }
    })

    useEffect(() => {
        
        if(channel){
            form.setValue("name", channel.name)
            form.setValue("type", channel.type)
        }

    }, [channel, form])

    const isLoading = form.formState.isSubmitting

    const onSubmit = async (values: z.infer<typeof formSchema>) => {
        

        try {

            const url = qs.stringifyUrl({
                url: `/api/channels/${channel?.Id}`,
                query: {
                  serverId: server?.uuid
                }
            });

            await axios.patch(url, values)

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

    
    return (
        <Dialog
            open={isModalOpen}
            onOpenChange={handleOnClose}
        >
            <DialogContent className="bg-white text-black p-0 overflow-hidden">
                <DialogHeader className="pt-8 px-6">
                    <DialogTitle className="text-center text-2xl font-extrabold">
                        Edit This Channel
                    </DialogTitle>
                </DialogHeader>
                {/* Start Body Content */}

                <Form {...form}>
                    <form className="space-y-8" onSubmit={form.handleSubmit(onSubmit)}>
                        <div className="space-y-8 px-6">
                            

                            <FormField
                                control={form.control}
                                name="name"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel
                                            className="uppercase text-xs font-bold text-zinc-500 dark:text-secondary/70"
                                        >
                                            Channel Name
                                        </FormLabel>
                                        <FormControl>
                                            <Input
                                                disabled={isLoading}
                                                className="bg-zinc-300/50 border-0 focus-visible:ring-0 text-black focus-visible:ring-offset-0"
                                                placeholder="Enter channel name"
                                                {...field}
                                            />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />

                            <FormField 
                                control={form.control}
                                name="type"
                                render={({ field }) =>(
                                    <FormItem>
                                        <FormLabel>Channel Type</FormLabel>
                                        <Select
                                            disabled={isLoading}
                                            onValueChange={field.onChange}
                                            defaultValue={field.value}
                                        >
                                            <FormControl>
                                                    <SelectTrigger
                                                        className="bg-zinc-300 border-0 focus:ring-0 text-black ring-offset-0 focus:ring-offset-0 focus:ring-offeset-0 capitalize outline-none"
                                                    >
                                                        <SelectValue
                                                            placeholder="Select A Channel Type"
                                                        />
                                                    </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                {Object.values(ChannelType).map((type) => (
                                                    <SelectItem
                                                        key={type}
                                                        value={type}
                                                        className="capitalize"
                                                    >
                                                        {type.toLocaleLowerCase()}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
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
 
