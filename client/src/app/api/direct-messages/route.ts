import { NextApiRequest, NextApiResponse } from 'next'
import { NextApiResponseServerIo } from '@/Types'
import { CurrentProfile } from '@/lib/currentProfile'
import { NextResponse } from "next/server";
import { PrismaOrm } from "@/lib/prismaOrm";
import { DirectMessage } from "@prisma/client";

const MESSAGEES_BATCH = 50

export async function GET(
      req: Request, 
) {
      //  console.log('SocketHandler Hit! req', req)
      //  console.log('SocketHandler Hit! res', res)  /// << yeilds nothing


    try {
        

      

        const profile = await CurrentProfile()

        

        const { searchParams } = new URL(req.url);

        

        const cursor = searchParams.get("cursor")
        

        const conversationId = searchParams.get("conversationId")
        console.log('Check conversationId', conversationId)
   
        if(!profile){
          return new NextResponse("Unauthorized", { status: 401 })
        }

        if(!conversationId){
          return new NextResponse("conversationId Is Missing: ", { status: 400 })
        }

        let messages: DirectMessage[] = [];

        if(cursor){
          // With Cursor
          messages = await PrismaOrm.directMessage.findMany({
            take: MESSAGEES_BATCH,
            skip: 1,
            cursor: {
              Id: parseInt(cursor),

            },
            where: {
              conversationId: parseInt(conversationId),
            },
            include: {
              member: {
                include: {
                  profile: true,
                }
              }
            },
            orderBy: {
              createdAt: "desc"
            }
          })
        }else{
          // No Cursor
          messages = await PrismaOrm.directMessage.findMany({
            take: MESSAGEES_BATCH,
            where: {
              conversationId: parseInt(conversationId),
            },
            include: {
              member: {
                include: {
                  profile: true,
                }
              }
            },
            orderBy: {
              createdAt: "desc"
            }
          })
        }
        
        let nextCursor = null

        if(messages.length === MESSAGEES_BATCH){
          nextCursor = messages[MESSAGEES_BATCH - 1].Id
        }

        return NextResponse.json(
          { 
            items: messages,
            nextCursor: nextCursor,
          }
        );
        

    } catch (error) {
        console.log("[DIRECT_MESSAGES_GET]", error)

        //return NextResponse.json({ message: "Internal Error" });
        return new NextResponse( "Internal Error", { status: 500} );
    }
}
