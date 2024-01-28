import {User, Server, Member, Profile} from "@prisma/client"

 export type SafeUser = Omit<
    User,
    "createdAt" | "updatedAt" | "emailVerified"
 > & {
    createdAt: string;
    updatedAt: string;
    emailVerified: string | null;
 }

 export type ServerWithMembersWithProfiles = Server & {
   members: (Member & { profile: Profile })[]
 }