import { PrismaClient } from "@prisma/client";

declare global {
  var prisma: PrismaClient | undefined;
}

const PrismaOrm = globalThis.prisma || new PrismaClient()

if(process.env.NODE_ENV === "production") globalThis.prisma = PrismaOrm

export default PrismaOrm;
 