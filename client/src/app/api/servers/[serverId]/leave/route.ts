import { NextResponse } from "next/server";

import { CurrentProfile } from "@/lib/currentProfile";
import prismaOrm from "@/lib/prismaOrm";

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
      return new NextResponse("Server ID missing", { status: 400 });
    }

    const server = await prismaOrm.server.update({
      where: {
        uuid: params.serverId,
        profileId: {
          not: profile.Id
        },
        members: {
          some: {
            profileId: profile.Id
          }
        }
      },
      data: {
        members: {
          deleteMany: {
            profileId: profile.Id
          }
        }
      }
    });

    return NextResponse.json(server);
    
  } catch (error) {
    console.log("[SERVER_ID_LEAVE]", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}