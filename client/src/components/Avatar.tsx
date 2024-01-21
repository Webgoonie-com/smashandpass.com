"use client"

import Image from "next/image";

interface AvatarProps {
  src: string | null | undefined;
}

const Avatar: React.FC<AvatarProps> = ({ src }) => {
  return ( 
    <Image 
      className="rounded-full"
      style={{width: "auto", height   : "auto"}}
      height={"30"}
      width={"30"}
      alt="Avatar" 
      src={src || '/images/userPlaceholder.jpg'}
      priority
    />
   );
}
 
export default Avatar;