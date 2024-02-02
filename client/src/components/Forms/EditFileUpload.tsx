"use client"

import Image from "next/image"
import React, { useState , useEffect} from "react"
import { X } from "lucide-react"
import { ActionTooltip } from "../actionTooltip"


interface ServerData {
    server: {
      imageUrl?: string;
      // Add other properties if needed
    };
    // Add other properties if needed
  }

interface EditFileUploadProps {
    onChange: (url?: string) => void
    value: string
    endpoint: "messageFile" | "serverImage"
    data: ServerData;
}


export const EditFileUpload = ({
    onChange,
    value,
    endpoint,
    data,
}: EditFileUploadProps) => {

    const [uploading, setUploading] = useState(false)
    const [selectedImage, setSelectedImage] = useState("")
    const [selectedFile, setSelectedFile] = useState<File | string>()
    const [imageData, setImageData] = useState({})


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

        setSelectedImage("");

        deleteImageFromServer({imageData: imageData});

        if (selectedFile) {
            setSelectedImage("");
            setSelectedFile(undefined);
            deleteImageFromServer(imageData)
        }
    }
    

    useEffect(() => {
        
      if(data?.server?.imageUrl){
        const imageUrlWithoutPublic = data?.server?.imageUrl.replace('/public', '');
        setSelectedImage(imageUrlWithoutPublic)
      }

    }, [data?.server?.imageUrl])
    
    // Do Better Security Checks
    if(selectedImage && selectedImage !== undefined  && selectedImage !== null && selectedImage !== "pdf"){
        
        return (
            <div className="row">
                <div className="relative h-60 w-60">
                   
                   {selectedImage ? 
                    (<>
                        <Image
                           
                            width="100"
                            height="100"
                            sizes="(max-width: 100px) 100, (max-width: 100px) 100vw, 100vw"
                            src={selectedImage}
                            alt={"Uploaded Image" as string} 
                            className="rounded-full w-full h-auto"
                            priority
                        />
                         <ActionTooltip
                            side="right"
                            align="center"
                            label="Remove Image"
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

export default EditFileUpload