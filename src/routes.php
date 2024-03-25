    <?php
    use App\Controllers\StatesController;
    use App\Controllers\ZonesController;
    use App\Controllers\PrayertimeController;
    use App\Controllers\PrayerByZoneController;
    use App\Controllers\ZonesByStatesController;
    use App\Controllers\PrayerTimeByDateController;

    $routes = [
        ''=> function() {
            require '../app/views/home.php';
        },
        'states' => function() {
            $controller = new StatesController();
            $controller->getAllStates();
        },
        'zones' => function() {
            $zones_controller = new ZonesController();
            $zones_controller->getAllZones();
        },
        'prayer_times' => function() {
            $zones_controller = new PrayertimeController();
            $zones_controller->getAllPrayerTimes();
        },
        'prayers_by_zone' => function() {
            $prayertime_controller_by_id = new PrayerByZoneController();
            $timeZoneId = isset($_GET['time_zone_id']) ? $_GET['time_zone_id'] : null;
            if ($timeZoneId) {
                $args = ['time_zone_id' => $timeZoneId];
                $prayertime_controller_by_id->getPrayerTimeByZone($args);
            } else {
            echo "Time zone ID is required";
            }
        },
        'zones_by_state' => function () {
            $zone_states_controller = new ZonesByStatesController();
            $state_id = isset($_GET['state_id']) ? $_GET['state_id'] : null;
            if ($state_id) {  
                $args = ['state_id' => $state_id];
                $zone_states_controller->getAllZonesByStateId($args);
            } else {
            echo "Time zone ID is required";
            }
        },
        'prayertime-by-date' => function () {
            $zone_states_controller = new PrayerTimeByDateController();
            $prayertimes_date = isset($_GET['prayertimes_date']) ? $_GET['prayertimes_date'] : null;
            $time_zone_id = isset($_GET['time_zone_id']) ? $_GET['time_zone_id'] : null;
            if ($prayertimes_date) {  
                $args = ['prayertimes_date' => $prayertimes_date, 'time_zone_id' => $time_zone_id];
                $zone_states_controller->getPrayerTimeByDate($args);
            } else {
            echo "Time zone ID is required";
            }
        },
        'subscribe-to-timezone' => function () {
            $time_zone_id = isset($_GET['time_zone_id']) ? $_GET['time_zone_id'] : null;
            $prayertimes_date = isset($_GET['prayertimes_date']) ? $_GET['prayertimes_date'] : null;
            if($time_zone_id){
                $url = 'http://localhost:3030/check-prayer-times';

                $data = [
                    'time_zone_id' => $time_zone_id,
                    'prayertimes_date' => $prayertimes_date
                ];
                
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

                $response = curl_exec($ch);
                curl_close($ch);
                echo 'response:', $response;
                $responseData = json_decode($response, true);

                
            }
        }
    ];
    ?>