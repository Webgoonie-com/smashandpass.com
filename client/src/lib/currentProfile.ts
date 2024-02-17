import  { PrismaOrm }  from "@/lib/prismaOrm"

import getCurrentUser from "@/actions/getCurrentUsers";
import { GiConsoleController } from "react-icons/gi";
import { CounterClockwiseClockIcon } from "@radix-ui/react-icons";

export const CurrentProfile = async () => {

    const currentUser = await getCurrentUser()
    
    const userId = currentUser?.id

    if(!userId) {
        
        return null
    }

    const profile = await PrismaOrm.profile.findUnique({
        where: { 
            userId: userId
        }
    });

    return profile;
}
 
