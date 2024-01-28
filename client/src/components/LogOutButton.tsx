"use client"


import React from 'react'
import Button from './Buttons/Button'
import { signOut } from 'next-auth/react'
import Avatar from './Avatar'

const handleLogOut = () => {

    signOut()
}

const LogOutButton = () => {
  return (
    <div>
        
    <button
    className="pb-3 mt-auto flex flex-col items-center"
        onClick={handleLogOut}
    >
        <Avatar src={'/images/userPlaceholder.jpg'} />
        <span className='font-semibold'>Log Out</span>
    </button>
    </div>
  )
}

export default LogOutButton