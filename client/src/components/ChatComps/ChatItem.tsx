"use client"

import { Member, MemberRole, Profile } from "@prisma/client";
import  UserAvatar from "@/components/UserAvatar";
import { ActionTooltip } from "../actionTooltip";
import * as z from "zod";
import axios from "axios";
import qs from "query-string";
import { zodResolver } from "@hookform/resolvers/zod";

import { useForm } from "react-hook-form";


import { cn } from "@/lib/utils";
import {
  Form,
  FormControl,
  FormField,
  FormItem,
} from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";

import Image from "next/image";
import { useEffect, useState } from "react";
import { useRouter, useParams } from "next/navigation";
import { useModal } from "@/Hooks/useModalStore";


import { Edit, FileIcon, ShieldAlert, ShieldCheck, Trash, X } from "lucide-react";
import { createInitialRouterState } from "next/dist/client/components/router-reducer/create-initial-router-state";


interface ChatItemProps {
    Id: number;
    profileId: number;
    content: string;
    member: Member & {
        profile: Profile;
    }
    timeStamp: string;
    fileUrl: string| null;
    deleted: boolean;
    currentMember:Member;
    isUpdated:boolean;
    socketUrl: string;
    socketQuery: Record<string, string>;
}

const roleIconMap = {
    "GUEST": null,
    "MODERATOR": <ShieldCheck className="h-4 w-4 ml-2 text-indigo-500" />,
    "ADMIN": <ShieldAlert className="h-4 w-4 ml-2 text-orange-500" />,
}
  
const formSchema = z.object({
    content: z.string().min(1),
});


export const ChatItem = ({
    Id,
    profileId,
    
    content,
    member,
    timeStamp,
    fileUrl,
    deleted,
    currentMember,
    isUpdated,
    socketUrl,
    socketQuery,
}: ChatItemProps) => {

    //Set up a file type
    
    const [isEditing, setIsEditing] = useState(false);

    const { onOpen } = useModal();

    const params = useParams();
    const router = useRouter();

    const form = useForm<z.infer<typeof formSchema>>({
        resolver: zodResolver(formSchema),
        defaultValues: {
          content: content
        }
    });

    const isLoading = form.formState.isSubmitting;

    const onSubmit = async (values: z.infer<typeof formSchema>) => {
        
        try {
            

            const url = qs.stringifyUrl({
                url: `${socketUrl}/${Id}`,
                query: socketQuery,
              });
        
              
             await axios.patch(url, {
                data: values,
                profileId: profileId as number,
             });

              
        
              form.reset();
              setIsEditing(false);
            
        } catch (error) {
            console.log('Error on message submit: ', error)
        }
    }  


    const onMemberClick = () => {
        
        
        if(member.Id === currentMember.Id){
            
            return;
        }

        router.push(`/servers/${params?.serverId}/conversations/${member.Id}`)

    }
    // This useEffect is for canceling Edit Button
    useEffect(() => {
        const handleKeyDown = (event: any) => {
          if (event.key === "Escape" || event.keyCode === 27) {
            setIsEditing(false);
          }
        };
    
        window.addEventListener("keydown", handleKeyDown);
    
        return () => window.removeEventListener("keyDown", handleKeyDown);
    }, []);





    
    useEffect(() => {
        form.reset({
          content: content,
        })
    }, [content, form]);


    const isAdmin = currentMember.role === MemberRole.ADMIN;
    const isModerator = currentMember.role === MemberRole.MODERATOR

    const isOwner = currentMember.Id === member.Id;

    const canDeleteMessage = !deleted && (isAdmin || isModerator || isOwner)

    const canEditMessage = !deleted && isOwner && !fileUrl;


    // Declare File Type Constant
    const fileType = fileUrl?.split(".").pop();

    // Dangerous file types
    const isPDF = fileType === "pdf" && fileUrl;
    const isEXE = fileType === "exe" && fileUrl;
    const isSQL = fileType === "sql" && fileUrl;
    const isPy = fileType === "py" && fileUrl;
    const isCs = fileType === "cs" && fileUrl;

    // Safe File Types
    const isTxt = fileType === "txt" && fileUrl;

    // Acceptable Images
    const isPng = fileType === "png" && fileUrl;
    const isJpg = fileType === "jpg" || fileType === "jpeg" && fileUrl;
    const isGif = fileType === "gif" && fileUrl;
    const isWebp = fileType === "webp" && fileUrl;

    const isRealImage = isPng || isJpg || isGif || isWebp && fileUrl;

    const isImage = !isPDF && !isEXE && !isSQL && !isPy && !isCs && !isTxt && isRealImage && fileUrl;


    

    return (
        <div id={`${Id}`} className="relative group flex items-center hover:bg-black/5 p-4 transition w-full">
            <div className="group flex gap-x-2 items-start w-full">
                <div
                    onClick={onMemberClick} 
                    className="cursor-pointer hover:drop-shadow-md transition">
                    <UserAvatar src={member.profile.imageUrl} />
                </div>
                <div className="w-full flex flex-col">
                    <div className="flex items-center gap-x-2">
                        <div className="flex items-center">
                            <p onClick={onMemberClick} className="font-semibold text-sm hover:underline cursor-pointer">
                                {member.profile.name}
                            </p>
                            <ActionTooltip label={member.role}>
                               {roleIconMap[member.role]}
                            </ActionTooltip>
                        </div>
                        <span
                            className="text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            {timeStamp}
                        </span>
                    </div>
                    <div 
                        className=""
                    >
                        
                        {isImage && (
                            <a 
                            href={fileUrl}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="realative aspect-square rounded-md mt-2 overflow-hidden border flex items-center bg-secondary h-48 w-48"
                            title={content}
                            >
                                <Image
                                 src={fileUrl}
                                 alt={content}
                                 width={192}
                                 height={192}
                                 
                                 className="object-cover"
                                />
                            </a>
                        )}

                        {isPDF && (
                            <div className="relative flex items-center p-2 mt-2 rounded-md bg-background/10">
                            <FileIcon className="h-10 w-10 fill-indigo-200 stroke-indigo-400" />
                            <a 
                              href={fileUrl}
                              target="_blank"
                              rel="noopener noreferrer"
                              className="ml-2 text-sm text-indigo-500 dark:text-indigo-400 hover:underline"
                            >
                              PDF File
                            </a>
                          </div>
                        )}

                        {!fileUrl && !isEditing && (
                            <p className={cn(
                                "text-sm text-zinc-600 dark:text-zinc-300",
                                deleted && "italic text-zinc-500 dark:text-zinc-400 text-xs mt-1"
                              )}>
                                {content}
                                {isUpdated && !deleted && (
                                  <span className="text-[10px] mx-2 text-zinc-500 dark:text-zinc-400">
                                    (edited)
                                  </span>
                                )}
                              </p>
                        )}


                        {!fileUrl && isEditing &&(
                            <Form {...form}>
                                <form
                                className="flex items-center w-[95%] gap-x-2 pt-2"
                                onSubmit={form.handleSubmit(onSubmit)}>
                                    <FormField
                                        control={form.control}
                                        name="content"
                                        render={({field}) =>(
                                            <FormItem className="flex-1">
                                                <FormControl>
                                                    <div className="relative w-full">
                                                        <Input
                                                            disabled={isLoading}
                                                            className="p-2 bg-zinc-200/90 dark:bg-zinc-700/75 
                                                            border-none border-0 focus-visible:ring-0 focus-visible:ring-offest-0 text-zinc-6010 dark:text-zinc-200"
                                                            placeholder="Edit this message"
                                                            {...field}
                                                        />
                                                    </div>
                                                </FormControl>
                                            </FormItem>
                                        )}
                                    />
                                    
                                    <Button disabled={isLoading} size="sm" variant="primary">Save</Button>
                                    
                                </form>
                                <span className="text-[10px] mt-1 text-zinc-400">
                                    [Press] `escape` to cancel, or [Press] `enter` to save.
                                </span>
                            </Form>
                        )}

                    </div>
                </div>

                {/* This Message Can Be Edited */}
                {canDeleteMessage && (
                    <div className="
                        hidden group-hover:flex items-center 
                        gap-x-2 absolute p-1 -top-2 right-5
                        bg-white dark:bg-zinc-800 
                        border-rounded-sm
                        ">

                        {canEditMessage && (
                            <ActionTooltip 
                            label="Edit"
                            >
                                <Edit
                                    onClick={() => setIsEditing(true)}
                                    className="
                                        cursor-pointer 
                                        ml-auto w-4 h-4 
                                        text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300 
                                        transition"
                                />
                            </ActionTooltip>
                        )}
                        
                        <ActionTooltip label="Delete">
                            <Trash
                                onClick={() => onOpen("deleteMessage", {
                                apiUrl: `${socketUrl}/${Id}`,
                                query: socketQuery,
                                })}
                                className="cursor-pointer ml-auto w-4 h-4 text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300 transition"
                            />
                        </ActionTooltip>
                        
                    </div>
                )}
            </div>
        </div>
    );
}
 
