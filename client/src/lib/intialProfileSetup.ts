import React from 'react'
import { useRouter, redirect  } from "next/navigation";
import prismaOrm from '@/lib/prismaOrm'
import getCurrentUser from '@/actions/getCurrentUsers'




export const IntialProfileSetup = async () => {
    
    
    async function redirectToSign() {
        
        // This needs to go to sign in page. don't redirect to home as it will cause a forever crashing loop.
        redirect('/test')
    }

    const user = await getCurrentUser()

    if(!user){

        return redirectToSign()
    }


    const profile = await prismaOrm.profile.findUnique({
        where: {
            userId: user.Id
        }
    })

    if(profile){
        console.log('profile Found')
        return profile;
    }

    const newProfile = await prismaOrm.profile.create({
        data: {
            userId: user.Id,
            name: `${user.name}`
        }
    })

    //return newProfile
}

