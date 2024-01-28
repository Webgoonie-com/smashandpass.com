"use client"

import React, { useEffect, useState } from 'react'
import { CreateServerModal } from '@/components/Modals/CreateServerModal'

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
        </>
    )
}
