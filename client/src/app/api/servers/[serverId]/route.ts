import { NextResponse } from "next/server";

import { CurrentProfile } from "@/lib/currentProfile";
import prismaOrm from "@/lib/prismaOrm";

export async function DELETE(
  req: Request,
  { params }: { params: { serverId: string } }
) {
  try {
    const profile = await CurrentProfile();

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    const server = await prismaOrm.server.delete({
      where: {
        Id: parseInt(params.serverId),
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

    const server = await prismaOrm.server.update({
      where: {
        Id: parseInt(params.serverId),
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