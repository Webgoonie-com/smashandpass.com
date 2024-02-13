"use client"


import React from 'react'
import Button from './Buttons/Button'
import { signOut } from 'next-auth/react'
import Avatar from './Avatar'

const handleLogOut = () => {

    signOut()
}

const LogOutButton = () => {

  // Default value if the variable is not defined

  const imageUrl = process.env.NEXT_PUBLIC_IMAGE_URL || "/images/"; 

  return (
    <div>
        
    <button
    className="pb-3 mt-auto flex flex-col items-center"
        onClick={handleLogOut}
    >
        <Avatar src={`${imageUrl}userPlaceholder.jpg`} />
        <span className='font-semibold'>Log Out</span>
    </button>
    </div>
  )
}

export default LogOutButton