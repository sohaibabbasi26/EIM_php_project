const axios = require('axios');
const schedule = require('node-schedule');
const {notifyPrayerTime} = require('./bin/socketServer.js')

let lastTimeZoneId;
let lastPrayerTimesDate;

const fetchPrayTmByTmZnIdAndDate = async (id, date) => {
    if (!id || !date) {
        console.error('Time zone ID and date must be provided');
        return; // Exit the function if either is undefined
    }

    try {
        const response = await axios.get(`http://localhost:4000/prayertime-by-date?time_zone_id=${id}&prayertimes_date=${date}`);
        console.log('raw response: ', response);
        console.log("response dot data: ", response.data);
        const reply = response?.data;
        return reply;
    } catch (err) {
        console.log("ERR:", err);
        return;
    }
}

const isTimeForPrayer = (prayerTime, now) => {

    console.log("fake prayer time at is time for prayer:", prayerTime);
    const date = prayerTime.date;

    for (const key of ['imsak', 'Subuh', 'syuruk', 'dhuhr', 'asr', 'maghrib', 'isha']) {
        const prayerDateTimeString = `${date}T${prayerTime[key]}`;
        // const prayerDateTimeString = `2024-03-25T${prayerTime}`;

        console.log('prayer time string', prayerDateTimeString)
        const prayerDateTime = new Date(prayerDateTimeString);
        
        console.log('prayer time ', prayerDateTime)

        const timeDifference = prayerDateTime - now;
        const FIVE_MINUTES = 5 * 60 * 1000; 
        console.log('prayer time:',prayerDateTime);
        console.log('now:', now);
        console.log('time left:', timeDifference);
        if (timeDifference >= 0 && timeDifference <= FIVE_MINUTES) {
            notifyPrayerTime({message: true , key : key});
            console.log(`It's time for ${key} prayer.`, timeDifference >= 0 && timeDifference <= FIVE_MINUTES);
            return true;
        } else {
            notifyPrayerTime({message: false , key : key});
            return false
        }
    }

    return false;
};

const checkPrayerTimeAndNotify = async (id, date) => {
    lastTimeZoneId = id;
    lastPrayerTimesDate = date;

    try {
        const testTime = '02:15';
        const prayerTimes = await fetchPrayTmByTmZnIdAndDate(id, date);
        const now = new Date();

        if (!Array.isArray(prayerTimes)) {
            console.error('Expected an array of prayer times, received:', prayerTimes);
            return;
        }

        prayerTimes.forEach(prayerTime => {
            if (isTimeForPrayer(prayerTime, now)) {
                console.log("the time is now!");
                

            } else {
                console.log("this isn't a time for a prayer!")
            }
        });

    } catch (error) {
        console.error(error);
    }
}

const scheduleCheckPrayerTimeAndNotify = () => {
    schedule.scheduleJob('* * * * *', () => {
        if (lastTimeZoneId && lastPrayerTimesDate) {
            checkPrayerTimeAndNotify(lastTimeZoneId, lastPrayerTimesDate);
        } else {
            console.log('No time zone ID or date available for scheduled task.');
        }
    });
};

scheduleCheckPrayerTimeAndNotify();

module.exports = {
    checkPrayerTimeAndNotify,
}