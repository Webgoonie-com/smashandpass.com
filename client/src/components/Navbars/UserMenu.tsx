"use client"

import React from 'react'

const UserMenu = () => {
  return (
    <div className='relative'>
        <div>
            <div
                onClick={() => { console.log('clicked Used Menu')}}
                className="
                hidden md:block text-sm font-semibold 
                py-3 px-4 rounded-full hover:bg-neutral-400
                transition cursor-pointer
            ">
                <span>User Menu</span>
            </div>
            
            
        </div>
    </div>
  )
}

export default UserMenu