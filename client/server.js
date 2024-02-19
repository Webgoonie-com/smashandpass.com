import express from "express";
import next  from "next";
import cors from "cors"
import dotenv from 'dotenv'

dotenv.config()

const dev = process.env.NODE_ENV !== "production";
const app = next({ dev });
const port = process.env.PORT || 7667;

const handle = app.getRequestHandler();

app.prepare().then(() => {
  const server = express();

  // Define custom routes here, if needed
 
  server.get("*", (req, res) => {
    return handle(req, res);
  });

 

  server.listen(port, (err) => {
    if (err) throw err;
    console.log(`> Ready on http://localhost:${port}`);
  });
});