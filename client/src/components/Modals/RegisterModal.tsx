"use client"

import { useCallback, useState } from "react";

import { FcGoogle } from "react-icons/fc";
import { 
  FieldValues, 
  SubmitHandler,
  useForm
} from "react-hook-form";
import axios from "axios";
import { AiFillGithub } from "react-icons/ai";
import { useRouter } from "next/navigation";

import useLoginModal from "@/hooks/useLoginModal";
import useRegisterModal from "@/hooks/useRegisterModal";

import { toast } from "react-hot-toast";

import Modal from "./Modal";
import Input from "../Inputs/Input";
import Heading from "../Heading";
import Button from "../Buttons/Button";
import { signIn } from "next-auth/react";

const RegisterModal= () => {
    const router = useRouter();

    const registerModal = useRegisterModal();
    const loginModal = useLoginModal();
    
    const [isLoading, setIsLoading] = useState(false);
  
    const { 
      register, 
      handleSubmit,
      formState: {
        errors,
      },
    } = useForm<FieldValues>({
      defaultValues: {
        name: '',
        email: '',
        password: '',
        confirmPassword: ''
      },
    });
  
    const onSubmit: SubmitHandler<FieldValues> = (data) => {
      
      setIsLoading(true);
  
      axios.post('/api/register', data)
      .then((callback) => {
        setIsLoading(false);
        toast.success('Registered!');
        registerModal.onClose();
        loginModal.onOpen();
      })
      .catch((error) => {
        //toast.error(error);
        toast.error("So Very Sorry Something Went Wrong Please Try Again");
      })
      .finally(() => {
        setIsLoading(false);
      })
    }
  
    const toggle = useCallback(() => {
      registerModal.onClose();
      loginModal.onOpen();
    }, [loginModal, registerModal])
  
    const bodyContent = (
      <div className="flex flex-col gap-4">
        <Heading
          title="Welcome to SmashAndPass"
          subtitle="Create an account today!"
        />
        <Input
          id="name"
          label="Your Name"
          disabled={isLoading}
          register={register}
          errors={errors}
          required
        />
        <Input
          id="email"
          label="Your Primary Email"
          disabled={isLoading}
          register={register}
          errors={errors}
          required
        />
        <Input
          id="password"
          label="Create A Password"
          type="password"
          disabled={isLoading}
          register={register}
          errors={errors}
          required
        />
        <Input
          id="confirmPassword"
          label="Retype Password"
          type="password"
          disabled={isLoading}
          register={register}
          errors={errors}
          required
        />
      </div>
    )
  
    const footerContent = (
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
              onClick={toggle}
              className="
                text-neutral-800
                cursor-pointer 
                hover:underline
              "> Log in</span>
          </p>
        </div>
      </div>
    )
  
    return (
      <Modal
        disabled={isLoading}
        isOpen={registerModal.isOpen}
        title="Register"
        actionLabel="Continue"
        onClose={registerModal.onClose}
        onSubmit={handleSubmit(onSubmit)}
        body={bodyContent}
        footer={footerContent}
      />
    );
  }
  
  export default RegisterModal;