import { authOptions } from "@/lib/auth";
import NextAuth from "next-auth/next";
import { NextApiRequest, NextApiResponse } from 'next'
import { NextApiResponseServerIo } from '@/Types'
import { CurrentProfile } from '@/lib/currentProfile'
import { NextResponse } from "next/server";

 async function SocketHandler(req: Request, res: NextApiResponse) {
    console.log('SocketHandler Hit!')

    // if (res.socket.server.io) {
    //     console.log("Already set up");
    //     res.end();
    //     return;
    // }

    const profile = await CurrentProfile()
    console.log('Line 18 Message Route currentProfile: ', profile)
    
    return NextResponse.json(profile);
    // // const io = new Server(res.socket.server);
    // // res.socket.server.io = io;

    // // io.on("connection", (socket) => {
    // //     socket.on("send-message", (obj) => {
    // //         io.emit("receive-message", obj);
    // //     })
    // // });

    // console.log('Setting up Socket');
    // res.end()
}

export { SocketHandler as GET, SocketHandler as POST }