import {User, Server, Member, Profile} from "@prisma/client"

 export type SafeUser = Omit<
    User,
    "createdAt" | "updatedAt" | "emailVerified"
 > & {     
      createdAt: string;
      updatedAt: string;
      password: string | null;
      emailVerified: string | null;
      hashedPassword: string | null | undefined;
 }

 export type ServerWithMembersWithProfiles = Server & {
   members: (Member & { profile: Profile })[]
 }
 