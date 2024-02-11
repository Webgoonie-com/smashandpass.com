"use client"


import React from 'react'
import { signOut, useSession } from "next-auth/react"


const Blank = () => {
    const {data: session, status} = useSession();

    const dataSessions = session;
    
    console.log('Session', session)

    return (
      <div>
        <h1>Blank Page</h1>
        {status === "authenticated" && (
          <div>
            <p>User ID: {session.user.uuid}</p>
            <p>Email: {session.user.email}</p>
            {/* Add more session information as needed */}
            <button onClick={() => signOut()}>Sign out</button>
          </div>
        )}
        {status === "loading" && <p>Loading...</p>}
        {status === "unauthenticated" && <p>Not authenticated</p>}
      </div>
    );
  }
  
  export default Blank;