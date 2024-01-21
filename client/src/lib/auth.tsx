import NextAuth, { NextAuthOptions, User, getServerSession } from "next-auth"
import { useSession } from "next-auth/react"
import { redirect, useRouter } from "next/navigation"

import CredentialsProvider from "next-auth/providers/credentials"
import GithubProvider from "next-auth/providers/github"
import GoogleProvider from "next-auth/providers/google"

import { NextResponse } from "next/server";


import prismaOrm from './prismaOrm'




export const authConfig: NextAuthOptions = {
    providers: [
        CredentialsProvider({
            name: "Credentials",
            credentials: {
                email: { label: "Your Email", type: "email" },
                password: { label: "Your Password", type: "password" },
            },
            async authorize(credentials, req) {

                if (!credentials || !credentials?.email || !credentials?.password) {
                    throw new Error('Invalid credentials');
                }
               

                const payload = {
                    email: credentials?.email,
                    password: credentials?.password,
                };
        
                // const dbUser = await fetch(
                // process.env.NEXT_PUBLIC_API_URL + "/auth/login",
                // {
                //     method: "POST",
                //     body: JSON.stringify(payload),
                //     headers: {
                //     "Content-Type": "application/json",
                //     },
                // }
                // );
        
                //console.log('Line 42: dbUser auth: lib/auth/ = ', dbUser)
        
                const dbUser = await prismaOrm.user.findFirst({
                    where: { email: credentials.email},
                });

                console.log('Line 51: user auth: lib/auth/ = ', dbUser)
        
                // if (dbUser && dbUser.password === credentials.password){
                //     const { password, createdAt, Id, ...dbUserWithoutPassword } = dbUser
                //     return dbUserWithoutPassword as User;
                // }
        
                // Return null if user data could not be retrieved
                return null;
            },
        }),
        GithubProvider({
            clientId: process.env.GITHUB_ID as string,
            clientSecret: process.env.GITHUB_SECRET as string,
        }),
        GoogleProvider({
            clientId: process.env.GOOGLE_CLIENT_ID as string,
            clientSecret: process.env.GOOGLE_CLIENT_SECRET as string,
        }),
    ],
    callbacks: {
        jwt({ token, user }) {
        if(user) {
            return {
            ...token,  
            }
        }

        return token;
        },
        session: async ({ session, token }) => {
        

        if(token && session.user) {
           
        }
        return session;
        }
    },
    // pages: {
    //     signIn: '/auth/login',
    //     signOut: '/auth/logout',
    //     error: '/auth/error',
    //     verifyRequest: '/auth/verify-request',
    //     newUser: '/auth/new-user'
    
    // },
    // Enable debug messages in the console if we are having problems
    debug: process.env.NODE_ENV === 'development',
    session: {
        strategy: 'jwt'
    },
    secret: process.env.NEXTAUTH_SECRET,
};


export default NextAuth(authConfig);

