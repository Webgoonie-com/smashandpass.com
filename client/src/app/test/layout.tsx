import type { Metadata } from "next";
import { Open_Sans } from "next/font/google";
import "../../app/globals.css";
import Navbar from "@/components/Navbars/navbar";
import ClientOnly from "@/components/ClientOnly";
import getCurrentUser from "@/actions/getCurrentUsers";
import { cn } from "@/lib/utils";

const font = Open_Sans({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: "SmashAndPass.com Chat & Streaming Application",
  description: "A Social Media Networking Dating Game",
};

export default async function TestLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {

  const currentUser = await getCurrentUser()

  console.log('currentUser', currentUser)
  return (
    
      <div 
        className={
          cn(
            font.className,
            "bg-white dark:bg-[#313338] text-indigo-600"
            )
        }> 
          <ClientOnly>
            <Navbar currentUser={currentUser as any} />
          </ClientOnly>
          {children}
       
      </div>
  );
}
