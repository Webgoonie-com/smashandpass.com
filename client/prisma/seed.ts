import { users } from './users'
import {PrismaClient } from '@prisma/client'


const prisma = new PrismaClient()


// data on user has to be accurate for typescript

async function main() {
    for (let user of users) {
        await prisma.user.create({
            data: user
        })
    }
}



main().catch(e =>{
    console.log(e)
    process.exit(1)
}).finally(() => {
    prisma.$disconnect()
})