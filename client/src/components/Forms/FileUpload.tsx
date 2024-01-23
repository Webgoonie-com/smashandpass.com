"use client"

import Image from "next/image"
import React, { useState } from "react"
import { X } from "lucide-react"
import getCurrentUsers from "@/Actions/getCurrentUsers"

interface FileUploadProps {
    onChange: (url?: string) => void
    value: string
    endpoint: "messageFile" | "serverImage"
}


export const FileUpload = ({
    onChange,
    value,
    endpoint
}: FileUploadProps) => {

    const [uploading, setUploading] = useState(false)
    const [selectedImage, setSelectedImage] = useState("")
    const [selectedFile, setSelectedFile] = useState<File>()
    const [imageData, setImageData] = useState({})

    //const currentUser = await getCurrentUsers()

    //console.log('currentUser: ', currentUser)

    async function deleteImageFromServer(imageData: {}){

        console.log('delete imageData: ', imageData)
        try {
        
            const data = imageData

            //data['user'] = currentUser;

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
            
            const responseData = await res.json();
            console.log(responseData);
            //setImageData(responseData)
            
            //onChange(responseData.url);

            //if(!res.ok)  throw new Error(await res.text())
        
        
        } catch (error) {
            console.log('Error', error)
        }
        
    }

    async function sendImageToServer(file: any) {
        console.log('Sending Image to Server', file)
        
        if(!file) return


        try {
        
            const data = new FormData()
            data.set('filename', file)

            const res = await fetch('/api/uploadsingleimg', {
                method: 'POST',
                body: data
            })
            
            const responseData = await res.json();
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

        console.log('handleDeleteImage event', event);

        console.log('deleteImage event', imageData);

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
                <div className="relative w-[35vw] h-[35vw]">
                   
                   {selectedImage ? 
                    (<>
                        <Image
                            fill={true}
                            src={selectedImage}
                            alt={"Uploaded Image" as string} 
                            //className="rounded-full"
                        />
                        <button
                            onClick={() => handleDeleteImage(selectedImage)}
                            className="bg-rose-800 text-white p-1 rounded-full absolute top-0 right-0 shadow-sm"
                            type="button"
                        >
                            <X  className="h-4 w-4" />
                        </button>
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

    return (
        <div className="relative h-20 ">
            <div className="space-y-6 p-10 mx-auto w-full">
                <span>Upload Channel Image</span>
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

export default FileUpload