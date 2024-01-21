import type { Metadata } from "next";
import { Open_Sans } from "next/font/google";
import "./globals.css";
import Navbar from "@/components/Navbars/navbar";

const font = Open_Sans({ subsets: ["latin"] });

export const metadata: Metadata = {
  title: "SmashAndPass.com Chat & Streaming Application",
  description: "A Social Media Networking Dating Game",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body className={font.className}>
        <Navbar />
        {children}
      </body>
    </html>
  );
}
