import next from "next"
import express from "express";
import cors  from "cors";

const dev = process.env.NODE_ENV !== "production";

const port = process.env.PORT || 3000;
const app = next({ dev })

app.prepare().then(() => {
    const server = express();

    server.listen(port, () => {console.log(`Server listening on port http://localhost:${port}`)})

    
})





