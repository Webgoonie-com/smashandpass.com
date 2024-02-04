

import { getServerSession } from 'next-auth/next';

import { authOptions } from '@/lib/auth';
import {PrismaOrm} from '@/lib/prismaOrm'
import React from 'react'


export async function getSession(){
    return await getServerSession(authOptions)
}

export default async function getCurrentUsers(){
    try {
        
        const session = await getSession()

        if(!session?.user?.email){
            return null;
        }

        const currentUser = await PrismaOrm.user.findUnique({
            where: {
                email: session.user.email as string,
            }
        })

        //console.log("Line 29 = currentUser", currentUser, "session.user", session.user);

        if(!currentUser){
            //console.log("Line 32 = !currentUserDetected")
            return null
        }

        return {
            ...currentUser,
            createdAt: currentUser.createdAt.toISOString(),
            updatedAt: currentUser.updatedAt.toISOString(),
            emailVerified: currentUser.emailVerified?.toISOString() || null,
            }

    } catch (error: any) {
        console.log('Line 37: Error', error)
        return null
    }
}

