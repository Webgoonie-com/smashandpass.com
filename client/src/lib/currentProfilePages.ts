import  { PrismaOrm }  from "@/lib/prismaOrm"

import { getServerSession } from "next-auth/next";
import getCurrentUser from "@/actions/getCurrentUsers";
import { NextResponse } from "next/server";
import { NextApiRequest } from "next";


import { authOptions } from "@/lib/auth"

export async function getSession() {
    return await getServerSession(authOptions);
}



export const CurrentProfilePages = async (req: NextApiRequest) => {

    const session = await getSession()
    //console.log('CurrentProfilePages session', session)
    
    const currentUser = await getCurrentUser()
    
    //console.log('Line 11 on currentProfilePages: ', currentUser)
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
 
