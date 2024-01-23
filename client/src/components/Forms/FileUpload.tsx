"use client"

import Image from "next/image"
import { useState } from "react"


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
            console.log('responseData', responseData);
            console.log('responseData.filename', responseData.filename);

            onChange(responseData.url);
            
            
            
            console.log('res', res?.url)

            if(!res.ok)  throw new Error(await res.text())
        
        
        } catch (error) {
            console.log('Error', error)
        }

    }
    
    const handleFileChange = (event: React.ChangeEvent<HTMLInputElement>) => {
        console.log('On Change');
        const file = event.target.files?.[0];
        if (file) {
            setSelectedImage(URL.createObjectURL(file));
            setSelectedFile(file);
            //onChange(URL.createObjectURL(file));
            sendImageToServer(file as any)
        }
    };
    

    //if(value && fileType !== undefined  && fileType !== null && fileType !== "pdf"){

    if(selectedImage && selectedImage !== undefined  && selectedImage !== null && selectedImage !== "pdf"){
        
        return (
            <div className="row">
                <div className="relative w-[35vw] h-[35vw]">
                   <span> File Uploaded</span>
                   {selectedImage ? 
                    (<>
                        <Image
                            fill={true}
                            src={selectedImage}
                            alt={"Uploaded Image" as string} 
                            //className="rounded-full"
                        />
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
                <span>File Upload Prior Yo</span>
                <label>
                    <input
                        type="file"
                        //className="hidden"
                        /* onChange={({ target }) => {
                            console.log('On Change')
                            if(target.files){
                                const file = target.files[0]
                                setSelectedImage(URL.createObjectURL(file))
                                setSelectedFile(file)

                                onChange(URL.createObjectURL(file));
                            }
                        }} */

                        onChange={handleFileChange}
                    />
                </label>
            </div>

        </div>
    )

}

export default FileUpload