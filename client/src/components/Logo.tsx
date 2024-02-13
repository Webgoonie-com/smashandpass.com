"use client"

import Image from "next/image";
import { useRouter } from "next/navigation";

const Logo = () => {
    const router = useRouter()

    // Default value if the variable is not defined

    const imageUrl = process.env.NEXT_PUBLIC_IMAGE_URL || "/images/"; 

    return ( 
        <Image
            onClick={() => router.push('/')}
            alt="Logo"
            className="hidden md:block cursor-pointer"
            style={{width: "auto", height   : "auto"}}
            height={"100"}
            width={"100"}
            src={`${imageUrl}logo.png`}
            priority
        />
    );
}
 
export default Logo;