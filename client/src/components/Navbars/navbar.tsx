"use client"

import Container from "../Container";
import Logo from "../Logo";
import Avatar from "../Avatar";
import UserMenu from "./UserMenu";
import React from "react";
import { SafeUser } from "@/Types";

interface NavarProps {
    currentUser?: SafeUser | null
}

const Navbar: React.FC<NavarProps> = ({
    currentUser
}) => {
    
    return ( 
        <div className="fixed w-full bg-slate-300 text-black z-50 shadow-sm mb-20">
            <div className="py-4 border-b-[1px] ">
                <Container>
                    <div className="
                        flex
                        flex-row
                        items-center
                        justify-between
                        gap-3
                        md:gap-0
                    ">
                        <Logo />
                        <UserMenu currentUser={currentUser} />
                     </div>
                </Container>
            </div>
        </div>
     );
}
 
export default Navbar;