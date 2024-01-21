import { PrismaAdapter } from "@next-auth/prisma-adapter"
import NextAuth, { NextAuthOptions, User, AuthOptions, getServerSession } from "next-auth";
import { useSession } from "next-auth/react";
import { redirect } from "next/navigation"

import CredentialsProvider from "next-auth/providers/credentials";
import GithubProvider from "next-auth/providers/github"
import GoogleProvider from "next-auth/providers/google"
import { NextResponse } from "next/server";
import { getSession } from "next-auth/react";

import prismaOrm from "./prismaOrm"



declare module 'next-auth' {
    interface User {
        id: number | undefined;
        email: string | string[] | undefined;
        password: string | undefined;
        hashedPassword: string | null | undefined;
    }
}

export const authOptions: AuthOptions = {
    adapter: PrismaAdapter(prismaOrm),
    providers: [
        CredentialsProvider({
            name: "Credentials",
            credentials: {
                email: { label: "Your Email", type: "email" },
                password: { label: "Your Password", type: "password" },
            },
            async authorize(credentials) {
                if (!credentials || !credentials?.email || !credentials?.password) {
                    throw new Error('Invalid credentials');
                }

                const payload = {
                    email: credentials?.email,
                    password: credentials?.password,
                };

                const dbUser = await prismaOrm.user.findUnique({
                    where: { 
                        email: payload.email 
                    },
                    select: {
                        id: true,
                        email: true,
                        hashedPassword: true,
                     }
                });

                console.log('Github Testing: ', dbUser, )

                if (!dbUser) {
                    throw new Error('Sorry there was an error');
                }

                const user: User = {
                    id: dbUser.id,
                    email: dbUser.email,
                    password: 'stopPeeking', // You can provide a dummy value for the password if necessary
                    hashedPassword: dbUser.hashedPassword || undefined, // Ensure it's not null
                };

                return Promise.resolve(user);
            },
        }),
        GithubProvider({
            clientId: process.env.GITHUB_CLIENT_ID as string,
            clientSecret: process.env.GITHUB_CLIENT_SECRET as string,
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
            //const userSession = await getSession();
        }

        return session;
        
        }
    },
    pages: {
        signIn: '/',
        //signIn: 'api/auth/signin',
        // signIn: '/auth/login',
        // signOut: '/auth/logout',
        // error: '/auth/error',
        // verifyRequest: '/auth/verify-request',
        // newUser: '/auth/new-user'
    
    },
    // Enable debug messages in the console if we are having problems
    debug: process.env.NODE_ENV === 'development',
    session: {
        strategy: 'jwt'
    },
    secret: process.env.NEXTAUTH_SECRET,
};


export default NextAuth(authOptions);