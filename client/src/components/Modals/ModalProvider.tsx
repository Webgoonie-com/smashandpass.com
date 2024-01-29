"use client"

import React, { useEffect, useState } from 'react'
import { CreateServerModal } from '@/components/Modals/CreateServerModal'
import { InviteModal } from '@/components/Modals/InviteModal'
import { EditServerModal } from '@/components/Modals/EditServerModal'

export const ModalProvider = () => {

    const [showIntialModal, setShowInitialModal] = useState(false);

    useEffect(() => {
        setShowInitialModal(true)
    },[]);

    if(!showIntialModal) {  
        return null
    }

    return (
        <>
            <CreateServerModal />
            <InviteModal />
            <EditServerModal />
        </>
    )
}
