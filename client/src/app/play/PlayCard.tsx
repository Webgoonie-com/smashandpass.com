import { styled } from 'goober'
import React from 'react'
import PlayHeader from './PlayHeader'
import { SiTinder } from 'react-icons/si'
import { PlayCardFooter } from './PlayCardFooter'
import PlayCardHeader from './PlayCardHeader'
import PlayCardItem  from './PlayCardItem'

const style = {
    wrapper: `h-[45rem] w-[27rem] flex flex-col rounded-lg overflow-hidden`,
    cardMain: `w-full flex-1 relative flex flex-col justify-center items-center bg-gray-500`,
    noMoreWrapper: `flex flex-col justify-center items-center absolute`,
    tinderLogo: `text-5xl text-red-500 mb-4`,
    noMoreText: `text-xl text-white`,
    swipesContainer: `w-full h-full overflow-hidden`,
  }

export const PlayCard = () => {
  return (
    <div className={style.wrapper}>
      <PlayCardHeader />
      <div className={style.cardMain}>
        <div className={style.noMoreWrapper}>
          <SiTinder className={style.tinderLogo} />
          <div className={style.noMoreText}>
            No More Profiles in your Location...
          </div>
        </div>
        <div className={style.swipesContainer}>
            
            
            <PlayCardItem />

         

        </div>
      </div>
      <PlayCardFooter />
    </div>
  )
}

