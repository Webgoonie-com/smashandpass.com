import { NextResponse } from "next/server";
import { MemberRole } from "@prisma/client";

import { CurrentProfile } from "@/lib/currentProfile";
import { PrismaOrm } from "@/lib/prismaOrm";



export async function POST(
  req: Request
) {

    try {

    const profile = await CurrentProfile();
    const { name, type } = await req.json();
    const { searchParams } = new URL(req.url);

    const serverId = searchParams.get("serverId");

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    if (!serverId) {
      return new NextResponse("Server ID missing", { status: 400 });
    }

    if (name === "lobby") {
      return new NextResponse("Name cannot be 'lobby'", { status: 400 });
    }

    const server = await PrismaOrm.server.update({
      where: {
        uuid: serverId,
        members: {
          some: {
            profileId: profile.Id,
            role: {
              in: [MemberRole.ADMIN, MemberRole.MODERATOR]
            }
          }
        }
      },
      data: {
        channels: {
          create: {
            profileId: profile.Id,
            name,
            type,
          }
        }
      }
    });

    return NextResponse.json(server);

  } catch (error) {
    console.log("CHANNELS_POST", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}