import Heading from '@/components/Heading'
import React from 'react'
import PlayHeader from './PlayHeader'
import { PlayCard } from './PlayCard'

const style = {
    wrapper: `relative h-full w-screen flex flex-col bg-[#222229]`,
    cardsContainer: `flex flex-col items-center justify-center flex-1 py-20`,
}

const Play = () => {
    return (
       <div className='relative'>
            <div className={style.wrapper}>
                {/* Header */}
                <PlayHeader
                    
                />
                <div className={style.cardsContainer}>
                    {/* Card */}
                    
                    <PlayCard 
                    
                    />
                </div>
            </div>
       </div>
    )
}

export default Play