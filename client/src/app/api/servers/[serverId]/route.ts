import { NextResponse } from "next/server";

import { CurrentProfile } from "@/lib/currentProfile";
import { PrismaOrm } from "@/lib/prismaOrm";
import { AiOutlineConsoleSql } from "react-icons/ai";

export async function DELETE(
  req: Request,
  { params }: { params: { serverId: string } }
) {
  console.log('API Hit DELETE')

  try {
    const profile = await CurrentProfile();

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    const server = await PrismaOrm.server.delete({
      where: {
        uuid: params.serverId,
        profileId: profile.Id,
      }
    });

    return NextResponse.json(server);
  } catch (error) {
    console.log("[SERVER_ID_DELETE]", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}

export async function PATCH(
  req: Request,
  { params }: { params: { serverId: string } }
) {
    
  try {
    const profile = await CurrentProfile();
    const { name, imageUrl } = await req.json();

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    const server = await PrismaOrm.server.update({
      where: {
        uuid: params.serverId,
        profileId: profile.Id,
      },
      data: {
        name,
        imageUrl,
      }
    });

    return NextResponse.json(server);
  } catch (error) {
    console.log("[SERVER_ID_PATCH]", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}