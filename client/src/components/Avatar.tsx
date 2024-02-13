"use client"

import Image from "next/image";

interface AvatarProps {
  src: string | null | undefined;
}

const Avatar: React.FC<AvatarProps> = ({ src }) => {

  // Default value if the variable is not defined

  const imageUrl = process.env.NEXT_PUBLIC_IMAGE_URL || "/images/"; 

  return ( 
    <Image 
      className="rounded-full"
      style={{width: "auto", height   : "auto"}}
      height={"30"}
      width={"30"}
      alt="Avatar" 
      src={src || `${imageUrl}userPlaceholder.jpg`}
      priority
    />
   );
}
 
export default Avatar;