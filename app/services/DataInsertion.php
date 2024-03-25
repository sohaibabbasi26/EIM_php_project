<?php 
require_once '../config/dbConnection.php';

$prayer_times_johor = [ 
    [
    'state' => 'MELAKA',
    'zone' => 'MLK01',
    'zone_name' => 'SELURUH NEGERI MELAKA',
    'prayer_times' => [
        '2024-03-25' => [
            'imsak' => '5:56 am',
            'subuh' => '6:06 am',
            'syuruk' => '7:14 am',
            'zohor' => '1:20 pm',
            'asar' => '4:19 pm',
            'maghrib' => '7:22 pm',
            'isyak' => '8:31 pm',
        ],
        '2024-03-26' => [
            'imsak' => '5:56 am',
            'subuh' => '6:06 am',
            'syuruk' => '7:13 am',
            'zohor' => '1:19 pm',
            'asar' => '4:18 pm',
            'maghrib' => '7:22 pm',
            'isyak' => '8:31 pm',
        ],
        '2024-03-27' => [
            'imsak' => '5:55 am',
            'subuh' => '6:05 am',
            'syuruk' => '7:13 am',
            'zohor' => '1:19 pm',
            'asar' => '4:19 pm',
            'maghrib' => '7:22 pm',
            'isyak' => '8:31 pm',
        ],
        '2024-03-28' => [
            'imsak' => '5:55 am',
            'subuh' => '6:05 am',
            'syuruk' => '7:13 am',
            'zohor' => '1:19 pm',
            'asar' => '4:19 pm',
            'maghrib' => '7:21 pm',
            'isyak' => '8:30 pm',
        ],
        '2024-03-29' => [
            'imsak' => '5:54 am',
            'subuh' => '6:04 am',
            'syuruk' => '7:12 am',
            'zohor' => '1:18 pm',
            'asar' => '4:20 pm',
            'maghrib' => '7:21 pm',
            'isyak' => '8:30 pm',
        ],
        '2024-03-30' => [
            'imsak' => '5:54 am',
            'subuh' => '6:04 am',
            'syuruk' => '7:12 am',
            'zohor' => '1:18 pm',
            'asar' => '4:20 pm',
            'maghrib' => '7:21 pm',
            'isyak' => '8:30 pm',
        ],
        '2024-03-31' => [
            'imsak' => '5:54 am',
            'subuh' => '6:04 am',
            'syuruk' => '7:12 am',
            'zohor' => '1:18 pm',
            'asar' => '4:21 pm',
            'maghrib' => '7:21 pm',
            'isyak' => '8:30 pm',
        ],
        '2024-04-01' => [
            'imsak' => '5:53 am',
            'subuh' => '6:03 am',
            'syuruk' => '7:11 am',
            'zohor' => '1:17 pm',
            'asar' => '4:21 pm',
            'maghrib' => '7:20 pm',
            'isyak' => '8:30 pm',
        ],
        '2024-04-02' => [
            'imsak' => '5:53 am',
            'subuh' => '6:03 am',
            'syuruk' => '7:11 am',
            'zohor' => '1:17 pm',
            'asar' => '4:22 pm',
            'maghrib' => '7:20 pm',
            'isyak' => '8:29 pm',
        ],
        '2024-04-03' => [
            'imsak' => '5:52 am',
            'subuh' => '6:02 am',
            'syuruk' => '7:10 am',
            'zohor' => '1:17 pm',
            'asar' => '4:22 pm',
            'maghrib' => '7:20 pm',
            'isyak' => '8:29 pm',
        ],
        '2024-04-04' => [
            'imsak' => '5:52 am',
            'subuh' => '6:02 am',
            'syuruk' => '7:10 am',
            'zohor' => '1:17 pm',
            'asar' => '4:22 pm',
            'maghrib' => '7:20 pm',
            'isyak' => '8:29 pm',
        ],
        '2024-04-05' => [
            'imsak' => '5:52 am',
            'subuh' =>'6:02 am',
            'syuruk' => '7:10 am',
            'zohor' => '1:16 pm',
            'asar' => '4:23 pm',
            'maghrib' => '7:20 pm',
            'isyak' => '8:29 pm',
        ],
        '2024-04-06' => [
            'imsak' => '5:51 am',
            'subuh' => '6:01 am',
            'syuruk' => '7:09 am',
            'zohor' => '1:16 pm',
            'asar' => '4:23 pm',
            'maghrib' => '7:19 pm',
            'isyak' => '8:29 pm',
        ],
        '2024-04-07' => [
            'imsak' => '5:51 am',
            'subuh' => '6:01 am',
            'syuruk' => '7:09 am',
            'zohor' => '1:16 pm',
            'asar' => '4:23 pm',
            'maghrib' => '7:19 pm',
            'isyak' => '8:29 pm',
        ],
    ],
    ]
];

foreach ($prayer_times_johor as $zone_data) {
    $zone_code = $zone_data['zone'];
    // Fetch the time_zone_id from the zones table
    $stmt = $pdo->prepare("SELECT time_zone_id FROM time_zones WHERE time_zone_code = :zone_code");
    $stmt->execute([':zone_code' => $zone_code]);
    $zone_id = $stmt->fetchColumn();
    echo '\n this is the id :' , $zone_id;

    foreach ($zone_data['prayer_times'] as $date => $times) {
        // Prepare the INSERT statement
        $insert_stmt = $pdo->prepare("INSERT INTO prayer_time (date, imsak, subuh, syuruk, dhuhr, asr, maghrib, isha, time_zone_id) VALUES (:date, :imsak, :subuh, :syuruk, :dhuhr, :asr, :maghrib, :isha, :time_zone_id)");
        echo 'this is the id : ', $zone_id;
        // Execute the insertion with data binding
        $insert_stmt->execute([
            ':date' => $date,
            ':imsak' => $times['imsak'],
            ':subuh' => $times['subuh'],
            ':syuruk' => $times['syuruk'],
            ':dhuhr' => $times['zohor'],
            ':asr' => $times['asar'],
            ':maghrib' => $times['maghrib'],
            ':isha' => $times['isyak'],
            ':time_zone_id' => $zone_id
        ]);
    }
}
echo "Data inserted successfully";

?>