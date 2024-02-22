import { useRouter } from 'next/navigation'
import { useState } from 'react'
import { AiFillGithub } from "react-icons/ai";
import { FcGoogle } from "react-icons/fc";
import { signIn } from 'next-auth/react'
import Button from "../Buttons/Button";

interface CredentialsFormProps {
    csrfToken?: string;
}


const CredentialsRegisterForm = (props: CredentialsFormProps) => {

    const router = useRouter();
    const [error, setError] = useState<string | null>(null)

    const goToLogin = () => {
      router.push("/signin");
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
    <div className=''>
        
        <h2 className="mb-8 text-2xl font-bold text-gray-800 dark:text-white">
                        Sign Up
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
                <input
                    type="password"
                    name="confirmPassword"
                    placeholder="Password"
                    required
                    className="w-full px-4 py-4 mb-4 border border-gray-300 rounded-md"
                />

                <button
                    type="submit"
                    className="w-full h-12 px-6 mt-4 text-lg text-white transition-colors duration-150 bg-blue-600 rounded-lg focus:shadow-outline hover:bg-blue-700"
                >
                    Sign Up
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
          <p>Already have an account?
            <span 
              onClick={goToLogin}
              className="
                text-neutral-800
                cursor-pointer 
                hover:underline
              "> Sign Up</span>
          </p>
        </div>
      </div>
    </div>
  )}

export default CredentialsRegisterForm