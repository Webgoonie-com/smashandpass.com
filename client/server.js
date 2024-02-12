import next from "next"
import express from "express";
import cors  from "cors";

import dotenv from 'dotenv';
dotenv.config();

const dev = process.env.NODE_ENV !== "production";

const port = process.env.PORT || 3000;
const app = next({ dev })

app.prepare().then(() => {
    const server = express();

    server.listen(port, (err) => {

        if(err) throw new Error

        console.log(`Server listening on port http://localhost:${port}`)
    })

    
})





