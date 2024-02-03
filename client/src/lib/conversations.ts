import { NextResponse } from "next/server";
import {PrismaOrm} from "./prismaOrm";


export const getOrCreateConversation = async (memberOneId: number, memberTwoId: string) => {
    
  console.log('Line 6 Getting getOrCreateConversation', memberOneId, memberTwoId);
   // Parse memberTwoId as a number
   const parsedMemberTwoId = parseInt(memberTwoId, 10);

  try {
        let conversation = await findConversation(memberOneId, parsedMemberTwoId) || await findConversation(parsedMemberTwoId, memberOneId);

        //console.log('Line 10 Getting conversation', conversation)


        if (!conversation) {
            
            //console.log('Line 14 Could not find conversation', memberOneId, memberTwoId);

            conversation = await createNewConversation(memberOneId, parsedMemberTwoId);
        }
        //console.log('Line 18 Yes We found conversation', memberOneId, memberTwoId);

        return conversation;

  } catch (error) {
    console.log('Error getting conversation', error)
  }
}

const findConversation = async (memberOneId: number, memberTwoId: number) => {
  try {
    return await PrismaOrm.conversation.findFirst({
      where: {
        AND: [
          { memberOneId: memberOneId },
          { memberTwoId: memberTwoId },
        ]
      },
      include: {
        memberOne: {
          include: {
            profile: true,
          }
        },
        memberTwo: {
          include: {
            profile: true,
          }
        }
      }
    });
  } catch {
    return null;
  }
}

const createNewConversation = async (memberOneId: number, memberTwoId: number) => {
  try {
    
    //console.log('createNewConversation', memberOneId, memberTwoId)

    return await PrismaOrm.conversation.create({
      data: {
        memberOneId,
        memberTwoId: parseInt(memberTwoId as any),
      },
      include: {
        memberOne: {
          include: {
            profile: true,
          }
        },
        memberTwo: {
          include: {
            profile: true,
          }
        }
      }
    })
  }
  catch {
    return null;
  }

  //  For Debugging Prurposes
  // catch (error) {
  //   console.log("[CREATE_NEW_CONVERATION]", error);
  //   return new NextResponse("Internal Error", { status: 500 });
  // }
}