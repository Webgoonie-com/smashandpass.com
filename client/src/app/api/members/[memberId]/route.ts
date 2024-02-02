import { NextResponse } from "next/server";

import { CurrentProfile } from "@/lib/currentProfile";
import PrismaOrm from "@/lib/prismaOrm";
import { AiOutlineConsoleSql } from "react-icons/ai";



export async function DELETE(req: Request,
      {params}: { params: {memberId: string} }
) {
    try {
        const profile = await CurrentProfile();
        const { searchParams } = new URL(req.url);
        

        const serverId = searchParams.get("serverId");
        console.log('Line 18 on member route.ts serverId', serverId);

        if (!profile) {
            return new NextResponse("Unauthorized" ,{ status: 401 });
        }

        if (!serverId) {
            return new NextResponse("Server ID missing", { status: 400 });
        }

        if (!params.memberId) {
            return new NextResponse("Member ID missing", { status: 400 });
        }

        const server = await PrismaOrm.server.update({
            where: {
                Id: parseInt(serverId),
                profileId: profile.Id,
              },
              data: {
                members: {
                  deleteMany: {
                    Id: parseInt(params.memberId),
                    profileId: {
                      not: profile.Id
                    }
                  }
                }
              },
              include: {
                members: {
                  include: {
                    profile: true,
                  },
                  orderBy: {
                    role: "asc",
                  }
                },
              }
        })

        return NextResponse.json(server);
        
    } catch (error) {
        console.log("[MEMBER_ID_DELETE]", error);
        return new NextResponse("Internal Error", { status: 500 });
    }
}

export async function PATCH(req: Request,
      {params}: { params: {memberId: string | number} }
) {
    try {
        const profile = await CurrentProfile();
        const { searchParams } = new URL(req.url);
        const {role } = await req.json()

        const serverId = (searchParams.get("serverId"));

        console.log('path rout.ts on serverId: ', serverId)

        const memberId = parseInt(params.memberId as string, 10);

        console.log('path rout.ts on memberId: ', memberId)
        
        if (!profile) {
            return new NextResponse("Unauthorized" ,{ status: 401 });
        }

        if (!serverId) {
            return new NextResponse("Server ID missing", { status: 400 });
        }

        if (!params.memberId) {
            return new NextResponse("Member ID missing", { status: 400 });
        }

        const server = await PrismaOrm.server.update({
            where: {
                Id: parseInt(serverId),
                profileId: profile.Id,
              },
              data: {
                members: {
                    update: {
                      where: {
                        Id: memberId,
                        profileId: {
                          not: profile.Id
                        }
                      },
                      data: {
                        role
                      }
                    }
                }
              },
              include: {
                members: {
                  include: {
                    profile: true,
                  },
                  orderBy: {
                    role: "asc"
                  }
                }
              }
              
        })

        return NextResponse.json(server);
        
    } catch (error) {
        console.log("[MEMBER_ID_DELETE]", error);
        return new NextResponse("Internal Error", { status: 500 });
    }

}