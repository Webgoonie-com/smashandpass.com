import { Server as NetServer } from 'http';
import { Server as ServerIO } from 'socket.io';

let ioInstance: ServerIO | null = null;

export const createSocketServer = (httpServer: NetServer): ServerIO => {
  if (!ioInstance) {
    ioInstance = new ServerIO(httpServer);
    // Additional configuration can be done here if needed
  }
  return ioInstance;
};

export const configureSocketServer = (httpServer: NetServer): void => {
  const path = "/api/socket/io";
  const io = createSocketServer(httpServer);
  io.path(path);
  // Additional configuration for socket.io can be done here
};

export const getSocketServer = (): ServerIO | null => {
  return ioInstance;
};
