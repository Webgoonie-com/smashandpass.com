"use client"

import { Button } from "@/components/ui/button";


const onClickMe = () => {
    console.log('Ayo ')
}


const TestPage = () => {
    return ( 
        <div className="flex-row py-20">
           <div className="text-center">
        
        <h2 className="text-3xl">SmashAndPass.com</h2>
            <p className="text-2xl text-amber-200">Brought To You This Evening Test</p>
            <Button onClick={onClickMe} variant={"purple"}>Click Me</Button>
            <div className="text">
              <div>Not Feeling It - okay {"it's"} working again</div>
            </div>

        </div>
        </div> 
    );
}
 
export default TestPage;