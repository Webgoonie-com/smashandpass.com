import { NextResponse } from "next/server";
import { MemberRole } from "@prisma/client";

import { CurrentProfile } from "@/lib/currentProfile";

import PrismaOrm from "@/lib/prismaOrm";

export async function DELETE(
  req: Request,
  { params }: { params: { channelId: string } }
) {
  try {
    const profile = await CurrentProfile();
    const { searchParams } = new URL(req.url);

    // this should the server uuid as serverId which is a string.
    const serverId = searchParams.get("serverId");

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    if (!serverId) {
      return new NextResponse("Server ID missing", { status: 400 });
    }

    if (!params.channelId) {
      return new NextResponse("Channel ID missing", { status: 400 });
    }

    const server = await PrismaOrm.server.update({
      where: {
        uuid: serverId,
        members: {
          some: {
            profileId: profile.Id,
            role: {
              in: [MemberRole.ADMIN, MemberRole.MODERATOR],
            }
          }
        }
      },
      data: {
        channels: {
          delete: {
            Id: parseInt( params.channelId),
            name: {
              not: "general",
            }
          }
        }
      }
    });

    return NextResponse.json(server);
  } catch (error) {
    console.log("[CHANNEL_ID_DELETE]", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}

export async function PATCH(
  req: Request,
  { params }: { params: { channelId: string } }
) {
  try {
    const profile = await CurrentProfile();
    
    const {name, type} = await req.json()

    const { searchParams } = new URL(req.url);

    // this should the server uuid as serverId which is a string.
    const serverId = searchParams.get("serverId");

    if (!profile) {
      return new NextResponse("Unauthorized", { status: 401 });
    }

    if (!serverId) {
      return new NextResponse("Server ID missing", { status: 400 });
    }

    if (!params.channelId) {
      return new NextResponse("Channel ID missing", { status: 400 });
    }

    if (name === "general") {
      return new NextResponse("Name cannot be 'general'", { status: 400 });
    }

    const server = await PrismaOrm.server.update({
      where: {
        uuid: serverId,
        members: {
          some: {
            profileId: profile.Id,
            role: {
              in: [MemberRole.ADMIN, MemberRole.MODERATOR],
            }
          }
        }
      },
      data: {
        channels: {
          update: {
            where: {
              Id: parseInt( params.channelId),
              NOT: {
                name: "general",
              }
            },
            data: {
              name,
              type,
            }
          }
        }
      }
    });

    return NextResponse.json(server);
  } catch (error) {
    console.log("[CHANNEL_ID_PATCH]", error);
    return new NextResponse("Internal Error", { status: 500 });
  }
}