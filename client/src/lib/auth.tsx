import NextAuth, { NextAuthOptions, User, getServerSession } from "next-auth";
import { useSession } from "next-auth/react";
import { redirect } from "next/navigation"

import CredentialsProvider from "next-auth/providers/credentials";
import GithubProvider from "next-auth/providers/github"
import GoogleProvider from "next-auth/providers/google"
import { NextResponse } from "next/server";
import { getSession } from "next-auth/react";

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
                    //return null;
                }
                

                const payload = {
                email: credentials?.email,
                password: credentials?.password,
                };
        
                const dbUser = await fetch(
                process.env.NEXT_PUBLIC_API_URL + "/auth/login",
                {
                    method: "POST",
                    body: JSON.stringify(payload),
                    headers: {
                    "Content-Type": "application/json",
                    },
                }
                );
        
                //console.log('Line 42: dbUser auth: lib/auth/ = ', dbUser)
        
                const user = await dbUser.json();
                //console.log('Line 45: user auth: lib/auth/ = ', user)
        
                if (!dbUser.ok) {
                    throw new Error(user.message);
                }
                
                if(user.admin){
                    //console.log('Detected Admin on Line 150', user.admin)
                }
                    // If no error and we have user data, return it
                if (
                    user !== null &&
                    user.user !== null
                ) {
                    //console.log('Success returning res.ok On Line 58', res.ok)
                    //console.log('Success returning User On Line 59', user)
                    return user.user;
                }
        
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
            role: user.role,
            uuid: user.uuid,
            token: user.token,
            name: user.firstName + ' ' +user.lastName,
            firstName: user.firstName,
            lastName: user.lastName,
            usrImage: user.usrImage,      
            }
        }

        return token;
        },
        session: async ({ session, token }) => {
        
            //const userSession = await getSession();

        if(token && session.user) {
            session.user.role = token.role;
            session.user.uuid = token.uuid,
            session.user.token = token.token,
            session.user.name = token.firstName + ' ' + token.lastName;
            session.user.firstName = token.firstName,
            session.user.lastName = token.lastName,
            session.user.email = token.email;
            session.user.image = token.usrImage;
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