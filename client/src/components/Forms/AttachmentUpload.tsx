"use client"

import Image from "next/image"
import React, { useState } from "react"
import { X } from "lucide-react"
import { ActionTooltip } from "../actionTooltip"
import { FileIcon } from "@radix-ui/react-icons"


interface AttachmentUploadProps {
    onChange: (url?: string) => void
    value: string
    endpoint: "messageFile"
}


export const AttachmentUpload = ({
    onChange,
    value,
    endpoint
}: AttachmentUploadProps) => {

    const fileType =value?.split(".").pop()

    const [uploading, setUploading] = useState(false)
    const [selectedImage, setSelectedImage] = useState("")
    const [selectedFile, setSelectedFile] = useState<File>()
    const [imageData, setImageData] = useState({})


    // console.log('ayo endpoint', endpoint)
    // console.log('ayo value', value)
    
    async function deleteImageFromServer(imageData: {}){

        try {
        


            const res = await fetch('/api/deleteImageFromServer', {
                method: 'POST',
                body: JSON.stringify(imageData),
                headers: {
                    'Content-Type': 'application/json',
                },
            })

            if (!res.ok) {
                throw new Error(`HTTP error! Status: ${res.status}`);
            }
            
           
        
        
        } catch (error) {
            console.log('Error', error)
        }
        
    }

    async function sendImageToServer(file: any) {
        
        if(!file) return

        try {
        
            const data = new FormData()
            data.set('filename', file)

            const res = await fetch('/api/uploadsingleimg', {
                method: 'POST',
                body: data
            })
            
            const responseData = await res.json();
            
            // console.log('responseData', responseData)
            // console.log('responseData.url', responseData.url)
            setImageData(responseData)
            
            onChange(responseData.url);

            if(!res.ok)  throw new Error(await res.text())
        
        
        } catch (error) {
            console.log('Error', error)
        }

    }
    
    const handleFileChange = (event: React.ChangeEvent<HTMLInputElement>) => {

        const file = event.target.files?.[0];
        if (file) {
            setSelectedImage(URL.createObjectURL(file));
            setSelectedFile(file);
            sendImageToServer(file as any)
        }
    };

    const handleDeleteImage = (event: string) => {

        // console.log('handleDeleteImage event', event);

        // console.log('deleteImage event', imageData);

        deleteImageFromServer({imageData: imageData});

        if (selectedFile) {
            setSelectedImage("");
            setSelectedFile(undefined);
            deleteImageFromServer(imageData)
        }
    }
    
    // Do Better Security Checks
    if(selectedImage && selectedImage !== undefined  && selectedImage !== null && selectedImage !== "pdf"){
        
        return (
            <div className="row">
                <div className="relative h-60 w-60">
                   
                   {selectedImage ? 
                    (<>
                        {/* <Image
                           
                            width="100"
                            height="100"
                            sizes="(max-width: 100px) 100, (max-width: 100px) 100vw, 100vw"
                            src={selectedImage}
                            alt={"Uploaded Image" as string} 
                            className="rounded-full w-full h-auto"
                            priority
                        /> */}
                        <FileIcon className="h-60 w-60 fill-indigo-200 stroke-indigo-400" />
                        <span className="font-semibold text-green-900">Attached Successfully...</span>
                         <ActionTooltip
                            side="right"
                            align="center"
                            label="Click To Remove Image"
                        >
                        <button
                            onClick={() => handleDeleteImage(selectedImage)}
                            className="bg-rose-800 text-white p-1 rounded-full absolute top-0 right-0 shadow-sm"
                            type="button"
                        >
                            <X  className="h-4 w-4" />
                        </button>
                        </ActionTooltip>
                    </>)
                    : 
                    (<>
                         <span className="text-indigo-900 text-2xl"> Upload Image</span>
                    </>)
                   }
    
                </div>
            </div>
        )
    }

    //console.log('fileType', fileType)


    if(value && fileType === "pdf"){
        console.log('fileType pdf found')
        return(
            <div className="relative flex flex-row w-full items-center p-2 mt-2 rounded-md bg-background/10">
                 <FileIcon 
                        className="h-10 w-10 fill-indigo-200"
                    />
                <a 
                    href={value}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="ml-2 min-w-[200px] uppercase text-sm text-indgo-500 dark:text-indigo-400 hover:underline"
                    title={value}

                >
                   
                    {fileType} - file
                </a>

                <button
                    onClick={() => handleDeleteImage(selectedImage)}
                    className="bg-rose-800 text-white p-1 rounded-full absolute top-2 right-2 shadow-sm"
                    type="button"
                >
                    <X  className="h-4 w-4" />
                </button>

            </div>
        )
    }

    return (
        <div className="relative h-20 ">
            <div className="space-y-6 p-10 mx-auto w-full">
                <span>Upload Attachment File</span>
                <label>
                    <input
                        type="file"
                        //className="hidden"
                        onChange={handleFileChange}
                    />
                </label>
            </div>

        </div>
    )

}

export default AttachmentUpload