import { PrismaClient } from "@prisma/client";

let PrismaOrm: PrismaClient;

if (process.env.NODE_ENV === "production") {
    PrismaOrm = new PrismaClient();
} else {
  if (!(global as any).prisma) {
    (global as any).prisma = new PrismaClient();
  }
  PrismaOrm = (global as any).prisma;
}
 
export default PrismaOrm;