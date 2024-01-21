"use client"

import React from 'react'
import { AiFillAudio, AiOutlineMenu, AiOutlineMenuFold } from 'react-icons/ai'
import Avatar from '../Avatar'

const UserMenu = () => {
  return (
    <div className='relative'>
        <div className="flex flex-row items-center gap-3">
            <div
                onClick={() => { console.log('clicked Used Menu')}}
                className="
                hidden md:block text-sm font-semibold 
                py-3 px-4 rounded-full hover:bg-neutral-400
                transition cursor-pointer
            ">
                <span>User Menu</span>
            </div>
            <div
                onClick={() => { console.log('clicked subUser Menu')} }
                className="
                    p-4 md:py-1 md:px-2 
                    border-[1px] border-neutral-200 flex flex-row
                    items-center gap-3 rounded-full cursour-pointer
                    hover:shadow-md transition
                ">
                <AiOutlineMenu />
                <div className='hidden md:block'>
                    <Avatar src={null} />
                </div>
            </div>
            
        </div>
    </div>
  )
}

export default UserMenu