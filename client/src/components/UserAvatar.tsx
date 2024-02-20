"use client"

import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { cn } from "@/lib/utils"

interface UserAvatarProps {
    src?: string | null
    className?: string
}

const UserAvatar = ({src, className}:UserAvatarProps) => {
    
    // Default value if the variable is not defined

    const imageUrl = process.env.NEXT_PUBLIC_IMAGE_URL || "/images/";

    console.log('Line 17 ${imageUrl}', `${imageUrl}`,)
    console.log('Line 18 ${src}: ', `${src}`,)
    console.log('Line 19 ${imageUrl} ${src}: ', `${imageUrl} ${src}`,)
    console.log('Line 20 imageUrl + src: ', imageUrl+src)
    return (
        <Avatar className={cn("h-7 w-7 md:h-10 md:w-10", className)}>
                <AvatarImage 
                alt="Avatar" 
                src={ src || `/images/userPlaceholder.jpg`}
                />
                
                <AvatarFallback
                    className="bg-slate-500 text-orange-700"
                >SP</AvatarFallback>
        </Avatar>

    )
}

export default UserAvatar