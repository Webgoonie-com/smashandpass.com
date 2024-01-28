"use client"

import React, { useCallback, useState } from 'react'
import { AiFillAudio, AiOutlineMenu, AiOutlineMenuFold } from 'react-icons/ai'
import Avatar from '../Avatar'
import MenuItem from './MenuItem'

import useRegisterModal from '@/Hooks/useRegisterModal'
import useLoginModal from '@/Hooks/useLoginModal'
import { signOut } from 'next-auth/react'
import { SafeUser } from '@/Types'
import { ModeToggle } from '../modeToggle'

interface UserMenuProps {
    currentUser?: SafeUser | null
}

const UserMenu: React.FC<UserMenuProps> = ({
    currentUser
}) => {
    const registerModal = useRegisterModal()
    const loginModal = useLoginModal()
    const [isOpen, setIsOpen] = useState(false)

    const toggleOpen = useCallback(() => {
        setIsOpen((value) => !value)
      }, []);

    
    
    return (
        <div className='relative'>
            <div className="flex flex-row items-center gap-3">
                <div
                    onClick={() => { console.log('clicked on Name from User Menu')}}
                    className="
                    md:block text-sm font-semibold 
                    py-3 sm:px-6 px-4 rounded-full hover:bg-neutral-400
                    transition cursor-pointer
                ">
                    
                    {currentUser ? (
                        <>
                        {currentUser.name}
                        </>
                    ) : (
                        <>
                        <span>User Menu</span>
                        </>
                    )}
                </div>
                <div className="md:block">
                    <ModeToggle />
                </div>
                <div
                    onClick={toggleOpen}
                    className="
                        p-4 md:py-1 md:px-2 
                        border-[1px] border-neutral-200 flex flex-row
                        items-center gap-3 rounded-full cursor-pointer
                        hover:shadow-md transition 
                    ">
                    <AiOutlineMenu />
                    <div className='hidden md:block'>
                        <Avatar src={currentUser?.image} />
                    </div>
                </div>
            </div>

            {isOpen && (
                <div className="absolute rounded-xl shadow-md sm:w-[30vw] md:w-3/4  w-[60vw] bg-white overflow-hidden md:right-0 top-12 text-sm">
                        <div className="flex flex-col cursor-pointer">
                          
                            
                            {currentUser ? (

                                <>
                                <MenuItem 
                                    onClick={() => {console.log('Clicked Blanked 1')}}
                                    label={'My Link Number 1'}
                                />
                                <MenuItem 
                                    onClick={() => {console.log('Clicked Blanked 2')}}
                                    label={'My Link Number 2'}
                                />

                                <MenuItem 
                                    onClick={() => {console.log('Clicked Blanked 3')}}
                                    label={'My Link Number 3'}
                                />
                                
                                <MenuItem 
                                    onClick={() => {console.log('Clicked Blanked 4')}}
                                    label={'My Link Number 4'}
                                />

                                <MenuItem 
                                    onClick={() => signOut()}
                                    label={'Logout'}
                                />
                                
                                
                                </>
                            ): (

                                <>
                                <MenuItem 
                                    onClick={loginModal.onOpen}
                                    label={'Login'}
                                />
                                <MenuItem 
                                    onClick={registerModal.onOpen}
                                    label={'SignUp'}
                                />
                                
                                </>    
                            )}

                        </div>
                </div>
            )}
        </div>
    )
}

export default UserMenu