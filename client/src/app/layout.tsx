import '@/app/globals.css'
import type { Metadata } from "next";
import { Open_Sans } from "next/font/google";

import RegisterModal from "@/components/Modals/RegisterModal";
import LoginModal from "@/components/Modals/LoginModal";
import ToasterProvider from "@/Providers/ToastProvider";
import { ThemeProvider } from "@/providers/Theme-Provider";
import { ModalProvider } from '@/providers/ModalProvider';
import {cn} from '@/lib/utils'
import { SocketProvider } from '@/Providers/SocketProvider';
import { QueryProvider } from '@/Providers/QueryProvider';
import AuthProvider from '@/Providers/AuthProvider';

export const metadata: Metadata = {
  title: "SmashAndPass.com Chat & Streaming Application",
  description: "A Social Media Networking Dating Game",
};

const font = Open_Sans({ subsets: ["latin"] });


export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en" suppressHydrationWarning={true}>
      <body 
          className={
             cn(font.className, "bg-white dark:bg-[#313338] text-orange-600")}
             >
          <AuthProvider>
            <ThemeProvider
              attribute="class"
              defaultTheme="dark"
              //forcedTheme="light"
              enableSystem={false}
              storageKey="smashandapass-theme"
            >
            <SocketProvider>
                <ToasterProvider />
                <RegisterModal />
                <LoginModal />
                <ModalProvider />
              
              
              <QueryProvider>
                {children}
              </QueryProvider>

            </SocketProvider>
            </ThemeProvider>
          </AuthProvider>
        </body>
    </html>
  )
}
