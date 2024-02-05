"use client"

import React, { useEffect, useState } from 'react'
import { CreateServerModal } from '@/components/Modals/CreateServerModal'
import { InviteModal } from '@/components/Modals/InviteModal'
import { EditServerModal } from '@/components/Modals/EditServerModal'
import { MemberModal } from '@/components/Modals/MemberModal'
import { CreateChannelModal } from '@/components/Modals/CreateChannelModal'
import { LeaveServerModal } from '@/components/Modals/LeaveServerModal'
import { DeleteServerModal } from '@/components/Modals/DeleteServerModal'
import { DeleteChannelModal } from '@/components/Modals/DeleteChannelModal'
import { EditChannelModal } from '@/components/Modals/EditChannelModal'
import { MessageFileModal } from '@/components/Modals/MessageFileModal'
import { DeleteMessageModal } from '@/components/Modals/DeleteMessageModal'

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
            <MemberModal />
            <CreateChannelModal />
            <LeaveServerModal />
            <DeleteServerModal />
            <DeleteChannelModal />
            <EditChannelModal />
            <MessageFileModal />
            <DeleteMessageModal />
        </>
    )
}
