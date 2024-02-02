import  prismaOrm  from "@/lib/prismaOrm"

import getCurrentUser from "@/actions/getCurrentUsers";

export const CurrentProfile = async () => {

    const currentUser = await getCurrentUser()
    

    const userId = currentUser?.id

    if(!userId) {
        console.log('returnig null on finding user')
        return null
    }

    const profile = await prismaOrm.profile.findUnique({
        where: { 
            Id: userId
        }
    });
    

    return profile;
}
 
