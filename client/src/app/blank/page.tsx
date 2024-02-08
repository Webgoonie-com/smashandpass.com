"use client"


import React from 'react'
import { signOut, useSession } from "next-auth/react"


const Blank = () => {
    const {data: session, status} = useSession();

    console.log('Session', session)

  return (
    <div>Blank Page</div>
  )
}

export default Blank