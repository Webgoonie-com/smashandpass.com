import React from 'react'
import { useRouter, redirect  } from "next/navigation";
import {PrismaOrm} from '@/lib/prismaOrm'
import getCurrentUser from '@/actions/getCurrentUsers'




export const IntialProfileSetup = async () => {
    //const router = useRouter()
    
    async function redirectToSign() {
        console.log('Redirecting to Sign In because session not found.')
        redirect('/signin')
    }

    const user = await getCurrentUser()

    if(!user){

        return redirectToSign()
    }


    const profile = await PrismaOrm.profile.findUnique({
        where: {
            userId: user.id
        }
    })

    if(profile){
        return profile;
    }

    const newProfile = await PrismaOrm.profile.create({
        data: {
            userId: user.id,
            name: `${user.name}`,
            imageUrl: user.image,
        }
    })

    return newProfile;
}

