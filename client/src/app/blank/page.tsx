"use client"


import React, { useEffect } from 'react';
import { signOut, useSession } from "next-auth/react"


const Blank = () => {
  
    const {data: session, status} = useSession();

    const dataSessions = session;
    
    console.log(dataSessions, 'dataSessions')
    useEffect(() => {
      if (status === 'loading') {
          console.log('Loading session data...');
          console.log('Line 14 on Blank/page.tsx = Session', session)
          console.log('Line 15 on Blank/page.tsx = status', status)
      }else{
        console.log('Loading session satus not loading = ...', status);
      }
  }, [session, status]);

    return (
      <div>
        <h1>Blank Pages</h1>
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