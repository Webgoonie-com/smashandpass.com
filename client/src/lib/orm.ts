import { PrismaClient } from "@prisma/client";

declare global {
  var prisma: PrismaClient | undefined;
};

export const orm = globalThis.prisma || new PrismaClient();

if (process.env.NODE_ENV !== "production") globalThis.prisma = orm