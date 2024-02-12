"use client"


import UserAvatar from '@/components/UserAvatar'
import Image from 'next/image'
import React, { useContext, useState } from 'react'
//import { SmashAndPassContext } from "@/Context/SmashAndPassContext"

const style = {
    wrapper: `h-24 py-11 text-white w-screen w-full items-center px-16 flex justify-between`,
    main: `flex  w-full justify-between items-center gap-4`,
    smashText: `text-5xl md:w-[35%] font-semibold mr-8 cursor-pointer`,
    leftMenu: `flex justify-evenly w-full gap-8 text-lg`,
    menuItem: `cursor-pointer hover:text-red-400 duration-300 hover:scale-110`,
    rightMenu: `flex gap-3 items-center`,
    currentAccount: `px-2 py-1 border border-gray-500 rounded-full flex items-center`,
    accountAddress: `ml-2`,
    authButton: `bg-white font-bold text-red-500 px-6 py-3 items-center ml-4 rounded-lg hover:bg-red-500 duration-300 hover:text-white`,
  }


const PlayHeader = () => {

    const [currentAccount, setCurrentAccount] = useState(true)
    //const { connectWallet, currentAccount, disconnectWallet } = useContext(SmashAndPassContext)

  return (
    <div className={style.wrapper}>
        <div className={style.main}>
            <h1 className={style.smashText}>
                Smash And Pass
            </h1>

            <div className={style.leftMenu}>
                <div className={style.menuItem}>Products</div>
                <div className={style.menuItem}>Learn</div>
                <div className={style.menuItem}>Safety</div>
                <div className={style.menuItem}>Support</div>
                <div className={style.menuItem}>Download</div>
            </div>

            <div className={style.rightMenu}>
                <div>English</div>

                {currentAccount ? (
                    <>
                        <div>
                            <UserAvatar
                                
                            />
                            <span className={style.accountAddress}>
                                {/* {currentAccount.slice(0, 6)}...{currentAccount.slice(39)} */}
                            </span>
                        </div>
                        <button
                            className={style.authButton}
                        >
                            Login
                        </button>
                    </>
                ) : null}
            </div>
        </div>
    </div>
  )
}

export default PlayHeader