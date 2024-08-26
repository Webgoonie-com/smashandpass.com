import { users } from './users.js'
import { PrismaClient } from '@prisma/client'


const prisma = new PrismaClient()


// data on user has to be accurate for typescript

async function main() {
    for (let user of users) {
        await prisma.user.createMany({
            data: user,
        })
    }
}



main().catch(e =>{
    console.log(e)
    throw new Error('Failed to seed data.');
}).finally(() => {
    prisma.$disconnect()
})