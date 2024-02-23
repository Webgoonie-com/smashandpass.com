// server.ts
const express = require('express');
const http = require('http');
const next = require('next');
const { Server: SocketIoServer } = require('socket.io');
const kurento = require('kurento-client');
const minimist = require('minimist');
const dotenv = require('dotenv');

dotenv.config();

const dev = process.env.NODE_ENV !== 'production';
const app = next({ dev });
const handle = app.getRequestHandler();
const port = process.env.PORT || 3000;

const server = express();
const httpServer = http.createServer(server);
const io = new SocketIoServer(httpServer);

const ws_uri = 'ws://localhost:8888/kurento';

app.prepare().then(() => {


kurento(ws_uri, (error, client) => {
    if (error) {
        console.error('Error connecting to Kurento:', error);
        process.exit(1);
    }else{
        console.log('Kurento connected Successfully!!!!')
    }

});

io.on('connection', (socket) => {
    console.log('A user connected');

    // Socket.io logic goes here

    socket.on('disconnect', () => {
        console.log('User disconnected');
    });
});

server.all('*', (req, res) => {
    return handle(req, res);
});


    httpServer.listen(port, () => {
        console.log(`> Ready on http://localhost:${port}`);
    });
});
