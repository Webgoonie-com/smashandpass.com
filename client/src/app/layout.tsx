import type { Metadata } from "next";
import { Open_Sans } from "next/font/google";
import "./globals.css";
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

export default async function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {

  const currentUser = await getCurrentUser()

  console.log('currentUser', currentUser)
  return (
    <html lang="en" suppressHydrationWarning>
      <body 
        className={
          cn(
            font.className,
            "bg-white dark:bg-[#313338] text-indigo-600"
            )
        }>
        <ThemeProvider
          attribute="class"
          defaultTheme="dark"
          //forcedTheme="light"
          enableSystem={false}
          storageKey="smashandapass-theme"
        >
          <ClientOnly>
            <ToasterProvider />
            <RegisterModal />
            <LoginModal />
            <Navbar currentUser={currentUser} />
          </ClientOnly>
          {children}
        </ThemeProvider>
      </body>
    </html>
  );
}
