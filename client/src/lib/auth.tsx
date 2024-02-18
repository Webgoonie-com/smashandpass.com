import { PrismaAdapter } from "@next-auth/prisma-adapter"
import NextAuth, { User, AuthOptions, NextAuthOptions} from "next-auth";
import { getSession } from 'next-auth/react';
import CredentialsProvider from "next-auth/providers/credentials";
import GithubProvider from "next-auth/providers/github"
import GoogleProvider from "next-auth/providers/google"
import bcrypt from "bcrypt"

import {PrismaOrm} from "./prismaOrm"


declare module 'next-auth' {
    interface Session {
        user: {
            email?: string | null | undefined;
            uuid?: string | null | undefined;
            role?: string | string[] | undefined | any;
        };
        expires: string;
    }
}
declare module 'next-auth' {
    interface User {
        id: number | undefined;
        uuid: string;
        role: string | string[] | undefined | any;
        email: string | string[] | undefined;
        password: string | undefined;
        hashedPassword: string | null | undefined;
    }
}

export const authOptions: NextAuthOptions = {
    adapter: PrismaAdapter(PrismaOrm),
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
                console.log('Payload:',  payload);

                const dbUser = await PrismaOrm.user.findUnique({
                    where: { 
                        email: payload.email 
                    },
                    select: {
                        id: true,
                        uuid: true,
                        name: true,
                        role: true,
                        emailVerified: true,
                        email: true,
                        hashedPassword: true,
                     }
                });

                if (!dbUser) {
                    throw new Error('Sorry there was an error');
                }

                if (!dbUser ||  !dbUser?.hashedPassword) {
                    throw new Error('Invalid Credentials');
                }

                // Is the password incrypted?

                const isCorrectPassword = await bcrypt.compare(
                    credentials?.password, 
                    dbUser.hashedPassword
                );

                // Is the password incrypted?
                if (!isCorrectPassword) {
                    throw new Error('Invalid Credentials');
                }
                

                const user: User = {
                    id: dbUser.id,
                    uuid: dbUser.uuid,
                    role: dbUser.role,
                    email: dbUser.email,
                    password: 'stopPeeking', // You can provide a dummy value for the password if necessary
                    hashedPassword: dbUser.hashedPassword || undefined, // Ensure it's not null
                };

                return user;
            },
        }),
        GithubProvider({
            clientId: process.env.GITHUB_CLIENT_ID as string,
            clientSecret: process.env.GITHUB_CLIENT_SECRET as string,
        }),
        GoogleProvider({
            clientId: process.env.GOOGLE_CLIENT_ID as string,
            clientSecret: process.env.GOOGLE_CLIENT_SECRET as string,
            // authorization: {
            //     params: {
            //         prompt: "consent",
            //         access_type: "offline",
            //         response_type: "code"
            //     }
            // }
        }),
    ],
    callbacks: {
        async jwt({ token, user, account, profile, isNewUser }) {

        //console.log('Line 113 auth.tsx = JWT Callback:', token, user);

        if (account) {
            token.accessToken = account.access_token
            token.id = user.uuid
        }

        if(user) {
            return {
            ...token,
            id: user.id,
            uuid: user.uuid,
            role: user.role, 
            }
        }

        return token;
        },
        async redirect({ url, baseUrl }) {
             // Allows relative callback URLs
            if (url.startsWith("/")) return `${baseUrl}${url}`
            // Allows callback URLs on the same origin
            else if (new URL(url).origin === baseUrl) return url
            
            return baseUrl
        },
        async session({ session, user, token }) {
        
        // console.log('Line 97 sessoin', session)
        // console.log('Line 98 token', token)
        

        if (token && session) {
            session.user = {
                email: token.email as string | null | undefined,
                uuid: token.uuid as string | null | undefined,
                role: token.role as string | string[] | undefined | any,
            };
        }

        return session;
        
        }
        ,
        async signIn({ user, account, profile, email, credentials }) {
            const isAllowedToSignIn = true
            if (isAllowedToSignIn) {
              return true
            } else {
              // Return false to display a default error message
              return false
              // Or you can return a URL to redirect to:
              // return '/unauthorized'
            }
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

export const getServerSession = async (req: any) => {
    return await getSession({ req }); // Ensure that getSession is imported from 'next-auth/react'
};

export default NextAuth(authOptions);