import  { PrismaOrm }  from "@/lib/prismaOrm"

import getCurrentUser from "@/actions/getCurrentUsers";

export const CurrentProfile = async () => {

    const currentUser = await getCurrentUser()
    
    //console.log('Line 8 currentProfile', currentUser)
    const userId = currentUser?.id

    if(!userId) {
        console.log('returnig null on finding user')
        return null
    }

    const profile = await PrismaOrm.profile.findUnique({
        where: { 
            Id: userId
        }
    });
    

    return profile;
}
 
