import { Server as NetServer } from "http";
import { NextApiRequest } from "next";
import { Server as ServerIO } from "socket.io";

import { NextApiResponseServerIo } from "@/Types";

export const config = {
  api: {
    bodyParser: false,
  },
};

const socketUrl = process.env.NEXTAUTH_URL || "";

console.log('Hitting Io.ts', socketUrl)

const ioHandler = (req: NextApiRequest, res: NextApiResponseServerIo) => {
  if (!res.socket.server.io) {
    console.log('Can Not Find Socket res.socket.server.io: ')
    const path = `/api/socket/io`;
    //const path = `${socketUrl}/api/socket/io`;
    const httpServer: NetServer = res.socket.server as any;
    const io = new ServerIO(httpServer, {
      path: path,
      addTrailingSlash: false,
    });
    res.socket.server.io = io;
  }

  res.end();
}

export default ioHandler;