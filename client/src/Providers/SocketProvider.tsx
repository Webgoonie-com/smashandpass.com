"use client";

import { 
  createContext,
  useContext,
  useEffect,
  useState
} from "react";
import { io as ClientIO } from "socket.io-client";

type SocketContextType = {
  socket: any | null;
  isConnected: boolean;
};

const SocketContext = createContext<SocketContextType>({
  socket: null,
  isConnected: false,
});


// We use Socket Hook
export const useSocket = () => {
  return useContext(SocketContext);
};

export const SocketProvider = ({ 
  children 
}: { 
  children: React.ReactNode 
}) => {
  const [socket, setSocket] = useState(null);
  const [isConnected, setIsConnected] = useState(false);

  useEffect(() => {
    const socketInstance = new (ClientIO as any)(process.env.NEXT_PUBLIC_SITE_URL!,
    {
      path: "/api/socket/io",
      addTrailingSlash: false,
    });
    
    console.log('socketInstance', socketInstance)

    socketInstance.on("connect", () => 
    {
        console.log('socketInstance conntected');

        setIsConnected(true);
    });

    socketInstance.on("disconnect", () => 
    {
        console.log('socketInstance disconnected');
        
        setIsConnected(false);
    });

    setSocket(socketInstance);

    return () => 
    {
      socketInstance.disconnect();
    }
  }, []);

  return (
    <SocketContext.Provider value={{ socket, isConnected }}>
      {children}
    </SocketContext.Provider>
  )
}