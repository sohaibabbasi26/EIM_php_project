module.exports = function (server) {
    const io = require('socket.io')(server, {
        cors: {
            origin: "http://localhost:3000", // Client's origin
            methods: ["GET", "POST"]
        }
    });

    io.on('connection', (socket) => {
        console.log('a user connected');

        socket.on('disconnect', () => {
            console.log('user disconnected');
        });
    });

    return io;
};