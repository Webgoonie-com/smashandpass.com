import { useRouter } from 'next/navigation'
import { useState } from 'react'
import { AiFillGithub } from "react-icons/ai";
import { FcGoogle } from "react-icons/fc";
import { signIn } from 'next-auth/react'
import Button from "../Buttons/Button";
import Image from "next/image";

interface CredentialsFormProps {
    csrfToken?: string;
}


const CredentialsForm = (props: CredentialsFormProps) => {

    const router = useRouter();
    const [error, setError] = useState<string | null>(null)

    const goToSignUp = () => {
        router.push("/signup");
    }
    
    const handleSubmit = async function (e:any) {
        e.preventDefault();
        const data = new FormData(e.currentTarget)

        const signInResponse = await signIn("credentials", {
            email: data.get('email'),
            password: data.get("password"),
            redirect: false,
        })

        if (signInResponse && !signInResponse.error) {
            //Redirect to homepage (/timeline)
            router.push("/");
        } else {
            //console.log("Error: ", signInResponse);
            //console.log("Error: ", signInResponse.error);
            setError("Your Email or Password is wrong!");
        }
    }
        
  return (
    <div>
          <h2 className="mb-8 text-2xl font-bold text-gray-800 dark:text-white">
            Sign In
          </h2>

        <div className="form">
            <form
                className="w-full mt-8 text-xl text-black font-semibold flex flex-col"
                onSubmit={handleSubmit}
            >
                {error && (
                    <span className="p-4 mb-2 text-lg font-semibold text-white bg-red-500 rounded-md">
                    {error}
                    </span>
                )}
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    required
                    className="w-full px-4 py-4 mb-4 border border-gray-300 rounded-md"
                />

                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    className="w-full px-4 py-4 mb-4 border border-gray-300 rounded-md"
                />

                <button
                    type="submit"
                    className="w-full h-12 px-6 mt-4 text-lg text-white transition-colors duration-150 bg-blue-600 rounded-lg focus:shadow-outline hover:bg-blue-700"
                >
                    Log in
                </button>


                
            </form>
        </div>

        <div className="flex flex-col gap-4 mt-3">
          <hr />
          <Button 
            outline 
            label="Continue with Google"
            icon={FcGoogle}
            onClick={() => signIn('google')} 
          />
          <Button 
            outline 
            label="Continue with Github"
            icon={AiFillGithub}
            onClick={() => signIn('github')}
          />
          <div 
            className="
              text-neutral-500 
              text-center 
              mt-4 
              font-light
            "
          >
            <p>Don{`'`}t Have An Account ?
              <span 
                onClick={ goToSignUp }
                className="
                  text-neutral-800
                  cursor-pointer 
                  hover:underline
                "> Sign Up</span>
            </p>
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


                
        </div>
    </div>
  )}

export default CredentialsForm