"use client"

import { useSocket } from '@/Providers/SocketProvider'
import { Badge } from '@/components/ui/badge'


const SocketIndicator = () => {

    const { isConnected } =  useSocket()

    if (!isConnected) {
        
        return (
            <Badge
                variant="outline" 
                className="bg-yellow-600 text-white border-none"
            >
                Fallback: polling every 1s ...SocketIndicator
            </Badge>
        )

    }

    return (
        <Badge 
          variant="outline" 
          className="bg-emerald-600 text-white border-none"
        >
          Live: Real-time updates
        </Badge>
      )

    }


export default SocketIndicator