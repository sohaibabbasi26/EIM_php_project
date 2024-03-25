<?php

function getPrayerTimes($date) {
    // Assuming $pdo is your database connection and it's available in this scope
    global $pdo;

    $controller = new App\Controllers\PrayerTimeByDateController();
    // You need to pass the timezone ID and date for which you want to retrieve the prayer times
    $args = [
        'time_zone_id' => 'Your_Timezone_ID', // replace with actual timezone ID
        'prayertimes_date' => $date
    ];

    return $controller->getPrayerTimeByDate($args);
}

$currentDateTime = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur'));

$prayerTimes = getPrayerTimes($currentDateTime->format('Y-m-d'));

foreach ($prayerTimes as $zone => $times) {
    foreach ($times as $prayer => $time) {
        $prayerTime = new DateTime($time, new DateTimeZone('Asia/Kuala_Lumpur'));
        if ($currentDateTime >= $prayerTime && $currentDateTime <= $prayerTime->modify('+10 minutes')) {
            playVoiceover($prayer, $zone);
        }
    }
}

function playVoiceover($prayer, $zone) {
    echo 'It is prayer time!';
}
?>