import next from "next"
import express from "express"
import cors  from "cors"

import dotenv from 'dotenv'
dotenv.config()

const dev = process.env.NODE_ENV !== "production"

const port = process.env.PORT || 3000
const app = next({ dev })

const handle = app.getRequestHandler()

app.prepare().then(() => {
    const server = express();
    server.use(cors());

    server.get('*', (req, res) =>   {
        return handle(req, res)
    })

    server.listen(port, (err) => {

        if(err) throw new Error

        console.log(`Server listening on port http://localhost:${port}`)
    })

    
})





