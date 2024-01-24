import { v4 as uuidv4 } from "uuid";
import { NextResponse } from "next/server";
import { MemberRole } from "@prisma/client";

import { CurrentProfile } from "@/lib/currentProfile";
import prismaOrm  from "@/lib/prismaOrm";

console.log('Hit Servers Id And Shit')
export async function POST(req: Request) {
  try {
    const { name, imageUrl } = await req.json();
    const profile = await CurrentProfile();

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    const server = await prismaOrm.server.create({
      data: {
        profileId: profile.Id,
        name,
        imageUrl,
        inviteCode: uuidv4(),
        channels: {
          create: [
            { name: "general", profileId: profile.Id }
          ]
        },
        members: {
          create: [
            { profileId: profile.Id, role: MemberRole.ADMIN }
          ]
        }
      }
    });

    return NextResponse.json(server);
  } catch (error) {
    console.log("[SERVERS_POST]", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}