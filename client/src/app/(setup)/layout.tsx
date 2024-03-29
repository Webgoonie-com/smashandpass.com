import type { Metadata } from "next";
import { Open_Sans } from "next/font/google";
import "../../app/globals.css";
import Navbar from "@/components/Navbars/navbar";
import ClientOnly from "@/components/ClientOnly";
import Modal from "@/components/Modals/Modal";
import RegisterModal from "@/components/Modals/RegisterModal";
import LoginModal from "@/components/Modals/LoginModal";
import ToasterProvider from "@/Providers/ToastProvider";

import getCurrentUser from "@/actions/getCurrentUsers";
import { ThemeProvider } from "@/providers/Theme-Provider";
import { cn } from "@/lib/utils";

const font = Open_Sans({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: "SmashAndPass.com Chat & Streaming Application",
  description: "A Social Media Networking Dating Game",
};

export default async function SetUpLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {

  

  

  return (
      <main className="relative md:pl-[72px] h-full">
          {children}
      </main>
  );
}
