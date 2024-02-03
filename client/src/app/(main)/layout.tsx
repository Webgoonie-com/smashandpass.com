import {SideBarNav}from "@/components/Navbars/SideBarNav"
import Navbar from "@/components/Navbars/navbar";
import ClientOnly from "@/components/ClientOnly";
import getCurrentUser from "@/actions/getCurrentUsers";
//import "../../app/globals.css";
const MainLayout = async({
    children,
    params,
} : {
    children: React.ReactNode,
    params: string
}) => {

    const currentUser = await getCurrentUser()

    

    return(
        <div className="h-full">
             <div className="flex-row mt-0 absolute">
                 <ClientOnly>
                    <Navbar currentUser={currentUser as any} />
                </ClientOnly>
             </div>

            <div className="mt-[70px] hidden md:flex h-full w-[72px] z-30 flex-col fixed inset-y-0">
                <SideBarNav />
            </div>
            <main className="md:pl-[72px] h-full">
                {children}
            </main>
        </div>
    )
}

export default MainLayout