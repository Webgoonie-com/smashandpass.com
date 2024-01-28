import  prismaOrm  from "@/lib/prismaOrm"

import getCurrentUser from "@/actions/getCurrentUsers";

export const CurrentProfile = async () => {

    const currentUser = await getCurrentUser()
    console.log('currentUser', currentUser)

    const userId = currentUser?.id

    const profile = await prismaOrm.profile.findUnique({
        where: { 
            Id: userId
        }
    });
    

    return profile;
}
 
