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
  const handleSubmit: FormEventHandler<HTMLFormElement> = async (e) => {
    // validate your userinfo
    e.preventDefault();

    const data = new FormData(e.currentTarget)
    console.log('data', data)

    const signInResponse = await signIn("credentials", {
      email: userInfo.email,
      password: userInfo.password,
      redirect: false,
    });

    console.log('signInResponse', signInResponse);

    if (signInResponse && !signInResponse.error) {
        //Redirect to homepage (/timeline)
        router.push("/");
    } else {
        //console.log("Error: ", signInResponse);
        //console.log("Error: ", signInResponse.error);
        setError("Your Email or Password is wrong!");
    }
  };
  return (
    <div className="sign-in-form">
      

      
      <div className="relative py-16">
        <div className="container relative m-auto px-6 text-gray-500 md:px-12 xl:px-40">
            <div className="w-full py-10">
            <div className="rounded-3xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-2xl shadow-gray-600/10 dark:shadow-none">
                <div className="p-8 py-12 sm:p-16">
                <div className="space-y-4">
                    
                    <Logo />

                    <h2 className="mb-8 text-2xl font-bold text-gray-800 dark:text-white">
                    Sign In
                    </h2>
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
                <div className="mt-16 grid space-y-4">
                    <button className="group relative flex h-11 items-center px-6 before:absolute before:inset-0 before:rounded-full before:bg-white dark:before:bg-gray-700 dark:before:border-gray-600 before:border before:border-gray-200 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 disabled:before:bg-gray-300 disabled:before:scale-100">
                    <span className="w-full relative flex justify-center items-center gap-3 text-base font-medium text-gray-600 dark:text-gray-200">
                        <Image
                            src="images/google.svg" 
                            width={"100"}
                            height={"100"}
                            className="absolute left-0 w-5"
                             alt="google logo"
                             priority
                         />
                        <span>Continue with Google</span>
                    </span>
                    </button>
                    <button className="group relative flex h-11 items-center px-6 before:absolute before:inset-0 before:rounded-full before:bg-white dark:before:bg-gray-700 dark:before:border-gray-600 before:border before:border-gray-200 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 disabled:before:bg-gray-300 disabled:before:scale-100">
                    <span className="w-full relative flex justify-center items-center gap-3 text-base font-medium text-gray-600 dark:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5 absolute left-0" viewBox="0 0 16 16">
                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                        </svg>
                        <span>Continue with Facebook</span>
                    </span>
                    </button>
                    <button className="group relative flex h-11 items-center px-6 before:absolute before:inset-0 before:rounded-full before:bg-white dark:before:bg-gray-700 dark:before:border-gray-600 before:border before:border-gray-200 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 disabled:before:bg-gray-300 disabled:before:scale-100">
                    <span className="w-full relative flex justify-center items-center gap-3 text-base font-medium text-gray-600 dark:text-gray-200">
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        className="w-5 h-5 absolute left-0"
                        viewBox="0 0 16 16"
                        >
                        <path
                            d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"
                        />
                        </svg>
                        <span>Continue with Github</span>
                    </span>
                    </button>
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