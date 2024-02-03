import { v4 as uuidv4 } from  "uuid"
import { NextResponse } from "next/server";

import { CurrentProfile } from "@/lib/currentProfile";
import { PrismaOrm } from "@/lib/prismaOrm";

export async function PATCH(
  req: Request,
  { params }: { params: { serverId: string } }
) {
  try {
    const profile = await CurrentProfile();

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    if (!params.serverId) {
      return new NextResponse("Server ID Missing", { status: 400 });
    }


    const server = await PrismaOrm.server.update({
      where: {
        uuid: params.serverId,
        profileId: profile.Id,
      },
      data: {
        inviteCode: uuidv4(),
      },
    });

    return NextResponse.json(server);
  } catch (error) {
    console.log("[SERVER_ID]", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}

