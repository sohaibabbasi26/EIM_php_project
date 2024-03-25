
const app = require('../server.js');
const http = require('http').createServer(app);
const io = require('../socket')(http);

function notifyPrayerTime(prayerInfo) {
  io.emit('prayerTime', prayerInfo); 
}

http.listen(4001, () => {
  console.log('listening on *:4001');
});

module.exports = { notifyPrayerTime };