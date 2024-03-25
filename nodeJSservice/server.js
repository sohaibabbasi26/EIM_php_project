const express = require('express');
const {checkPrayerTimeAndNotify} = require('./handlers.js');

const app = express();
app.use(express.json());

app.get('/',(req, res) => {

    res.send('server is running!');
})

app.post('/check-prayer-times', (req, res) => {
    const {time_zone_id, prayertimes_date} = req.body;
    console.log('retrieved time zone id:', time_zone_id, 'and date:',prayertimes_date );
    // Your function to check prayer times
    // checkPrayerTimeAndNotify(timeZoneId);
    checkPrayerTimeAndNotify(time_zone_id, prayertimes_date);
    res.status(200).json({ message: `The retrieved time zone id is: ${time_zone_id, prayertimes_date}` });  });

app.listen(3030, () =>{
    console.log('server is listening at port 3030');
})

module.exports = app;