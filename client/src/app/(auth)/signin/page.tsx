"use client"

import Image from "next/image";
import Logo from "@/components/Logo";
import { NextPage } from "next";
import { signIn } from "next-auth/react";
import { FormEventHandler, useState } from "react";
import { useRouter } from 'next/navigation'
import CredentialsForm from "@/components/Forms/credentialsForm";


interface Props {}

const SignIn: NextPage = (props): JSX.Element => {
    
  const router = useRouter();
  const [error, setError] = useState<string | null>(null)

  const [userInfo, setUserInfo] = useState({ email: "", password: "" });

  return (
    <div className="sign-in-form">
      

      
      <div className="relative py-16">
        <div className="container relative m-auto px-6 text-gray-500 md:px-12 xl:px-40">
            <div className="w-full py-10">
            <div className="rounded-3xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-2xl shadow-gray-600/10 dark:shadow-none">
                <div className="p-8 py-12 sm:p-16">
                <div className="space-y-4 mt-40">
                    
                    <Logo />

                   
                    {/* <form onSubmit={handleSubmit}>
                        <h1>Login</h1>
                        <input
                        className="w-full"
                        value={userInfo.email}
                        onChange={({ target }) =>
                            setUserInfo({ ...userInfo, email: target.value })
                        }
                        type="email"
                        placeholder="your email"
                        />
                        <input
                        
                        className="w-full"
                        value={userInfo.password}
                        onChange={({ target }) =>
                            setUserInfo({ ...userInfo, password: target.value })
                        }
                        type="password"
                        placeholder="********"
                        />
                        <input type="submit" value="Login" />
                    </form> */}

                        <div className="container">
                            <CredentialsForm />
                        </div>

                    
                </div>
               

                <div className="mt-32 space-y-4 text-center text-gray-600 dark:text-gray-400 sm:-mb-8">
                    <p className="text-xs">
                    By proceeding, you agree to our <a href="#" className="underline">Terms of Use</a> and
                    confirm you have read our
                    <a href="#" className="underline">Privacy and Cookie Statement</a>.
                    </p>
                    <p className="text-xs">
                    This site is protected by reCAPTCHA and the
                    <a href="#" className="underline">Google Privacy Policy</a> and
                    <a href="#" className="underline">Terms of Service</a> apply.
                    </p>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
                                    


    </div>
  );
};

export default SignIn;