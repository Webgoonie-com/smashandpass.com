import React from 'react'
import { useRouter, redirect  } from "next/navigation";
import prismaOrm from '@/lib/prismaOrm'
import getCurrentUser from '@/actions/getCurrentUsers'




export const IntialProfileSetup = async () => {
    //const router = useRouter()
    
    async function redirectToSign() {
        console.log('Redirecting to Sign In because session not found.')
        redirect('/test')
    }

    const user = await getCurrentUser()

    if(!user){

        return redirectToSign()
    }


    const profile = await prismaOrm.profile.findUnique({
        where: {
            userId: user.id
        }
    })

    if(profile){
        return profile;
    }

    const newProfile = await prismaOrm.profile.create({
        data: {
            userId: user.id,
            name: `${user.name}`
        }
    })
}

