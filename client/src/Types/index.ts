import {User, Server, Member, Profile} from "@prisma/client"
import {Server as NetServer, Socket} from "net"
import { NextApiResponse } from "next";
import { Server as SocketIoServer } from "socket.io"

 export type SafeUser = Omit<
    User,
    "createdAt" | "updatedAt" | "emailVerified"
 > & {
      role: string;
      createdAt: string;
      updatedAt: string;
      password: string | null;
      emailVerified: string | null;
      hashedPassword: string | null | undefined;
 }

 export type ServerWithMembersWithProfiles = Server & {
   members: (Member & { profile: Profile })[]
 }

 
 export type NextApiResponseServerIo = NextApiResponse & {
  socket: Socket & {
    server: NetServer & {
      io: SocketIoServer;
    }
  }
}