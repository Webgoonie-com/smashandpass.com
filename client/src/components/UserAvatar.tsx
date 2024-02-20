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


    return (
        <Avatar className={cn("h-7 w-7 md:h-10 md:w-10", className)}>
                <AvatarImage 
                alt="Avatar" 
                src={ src || `${imageUrl}userPlaceholder.jpg`}
                />
                
                <AvatarFallback
                    className="bg-slate-500 text-orange-700"
                >SP</AvatarFallback>
        </Avatar>

    )
}

export default UserAvatar