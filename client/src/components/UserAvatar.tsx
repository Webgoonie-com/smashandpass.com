import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { cn } from "@/lib/utils"

interface UserAvatarProps {
    src?: string | null
    className?: string
}

const UserAvatar = ({src, className}:UserAvatarProps) => {

    
    return (
        <Avatar className={cn("h-7 w-7 md:h-10 md:w-10", className)}>
                <AvatarImage 
                alt="Avatar" 
                src={src || '/images/userPlaceholder.jpg'}
                />
                
                <AvatarFallback
                    className="bg-slate-500 text-orange-700"
                >SP</AvatarFallback>
        </Avatar>

    )
}

export default UserAvatar