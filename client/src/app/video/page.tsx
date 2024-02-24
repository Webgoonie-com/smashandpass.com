'use client'

import React from 'react'
import Head from 'next/head'
import Script from 'next/script'




const VideoPage = () => {
    
  
    return (
        <>
                <Head>
                    
                        <title>WebRTC Video Conference Tutorial - Media Server</title>
                        
                        <meta charSet='utf-8' />
                </Head>

            <div>

            

                <h1>WebRTC Video Conference Tutorial - Media Server</h1>

                <div id="roomSelection" className="roomSelection" style={{display: 'block'}}>
                    <label>Type user name:</label>
                    <input id="name" type="text" />
                    <label>Type room name:</label>
                    <input id="room" type="text" />
                    <button id="register">Enter</button>
                </div>

                    Media room
                <div id="meetingRoom" style={{display: 'none'}}>
                </div>
            

            <Script src="adapter.js"></Script>
            <Script src="kurento-utils.min.js"></Script>
            {/* <Script src="https://cdn.socket.io/socket.io-1.2.0.js"></Script> */}
            {/* <Script src="/socket.io/socket.io.js"></Script> */}
            {/* <Script src="/api/socket/io"></Script> */}
            <script src="/socket.io/socket.io.js"></script>
            <Script src="client.js"></Script>

            </div>
        </>
    )
}

export default VideoPage