<?php
// NOTE respon API
function apiResponse($message, $code, $data = null)
{
    return response()->json([
        'statuscode'    => $code,
        'message'       => $message,
        'data'          => $data
    ], $code);
}

function calculateLeaseTimestamp($lastSeen)
{
    $duration = dhcpLeaseDurationToSeconds($lastSeen);

    $currentTimestamp = time();
    $leaseTimestamp = $currentTimestamp - $duration;

    return $leaseTimestamp;
}

function dhcpLeaseDurationToSeconds($duration)
{
    if (strpos($duration, 'w') && strpos($duration, 'h') && strpos($duration, 'm') && strpos($duration, 's')) {
        preg_match('/(\d+)w(\d+)h(\d+)m(\d+)s/', $duration, $matches);

        $days = isset($matches[1]) ? intval($matches[1]) * 7 : 0;
        $hours = isset($matches[2]) ? intval($matches[2]) : 0;
        $minutes = isset($matches[3]) ? intval($matches[3]) : 0;
        $seconds = intval($matches[4]);
    } else if (strpos($duration, 'd') && strpos($duration, 'h') && strpos($duration, 'm') && strpos($duration, 's')) {
        preg_match('/(\d+)d(\d+)h(\d+)m(\d+)s/', $duration, $matches);

        $days = isset($matches[1]) ? intval($matches[1]) : 0;
        $hours = isset($matches[2]) ? intval($matches[2]) : 0;
        $minutes = isset($matches[3]) ? intval($matches[3]) : 0;
        $seconds = intval($matches[4]);
    } else if (strpos($duration, 'w') && strpos($duration, 'h') && strpos($duration, 'm')) {
        preg_match('/(\d+)w(\d+)h(\d+)m(\d+)s/', $duration, $matches);

        $days = isset($matches[1]) ? intval($matches[1]) * 7 : 0;
        $hours = isset($matches[2]) ? intval($matches[2]) : 0;
        $minutes = isset($matches[3]) ? intval($matches[3]) : 0;
        $seconds = 0;
    } else if (strpos($duration, 'h') && strpos($duration, 'm') && strpos($duration, 's')) {
        preg_match('/(\d+)h(\d+)m(\d+)s/', $duration, $matches);


        $days = 0;
        $hours = isset($matches[1]) ? intval($matches[1]) : 0;
        $minutes = isset($matches[2]) ? intval($matches[2]) : 0;
        $seconds = intval($matches[3]);
    } else if (strpos($duration, 'h') && strpos($duration, 'm')) {
        preg_match('/(\d+)h(\d+)m/', $duration, $matches);


        $days = 0;
        $hours = isset($matches[1]) ? intval($matches[1]) : 0;
        $minutes = isset($matches[2]) ? intval($matches[2]) : 0;
        $seconds = 0;
    } elseif (strpos($duration, 'm') && strpos($duration, 's')) {
        preg_match('/(\d+)m(\d+)s/', $duration, $matches);

        $days = 0;
        $hours = 0;
        $minutes = isset($matches[1]) ? intval($matches[1]) : 0;
        $seconds = intval($matches[2]);
    } elseif (strpos($duration, 'w')) {
        preg_match('/(\d+)d/', $duration, $matches);

        dump($duration);

        $days = intval($matches[1]) * 7;
        $hours = 0;
        $minutes =  0;
        $seconds = 0;
    } elseif (strpos($duration, 'd')) {
        preg_match('/(\d+)d/', $duration, $matches);

        $days = intval($matches[1]);
        $hours = 0;
        $minutes =  0;
        $seconds = 0;
    } elseif (strpos($duration, 'h')) {
        preg_match('/(\d+)h/', $duration, $matches);

        $days = 0;
        $hours = intval($matches[1]);
        $minutes =  0;
        $seconds = 0;
    } elseif (strpos($duration, 'm')) {
        preg_match('/(\d+)m/', $duration, $matches);

        $days = 0;
        $hours = 0;
        $minutes =  intval($matches[1]);
        $seconds = 0;
    } elseif (strpos($duration, 's')) {
        preg_match('/(\d+)s/', $duration, $matches);

        $days = 0;
        $hours = 0;
        $minutes =  0;
        $seconds = intval($matches[1]);
    } else {
        dd($duration);
    }

    $totalSeconds =  ($days * 86400) + ($hours * 3600) + ($minutes * 60) + $seconds;

    // $days = floor($totalSeconds / 86400);
    // $hours = floor(($totalSeconds % 86400) / 3600);
    // $minutes = floor(($totalSeconds % 3600) / 60);
    // $seconds = $totalSeconds % 60;

    // return sprintf('%d days, %02d:%02d:%02d', $days, $hours, $minutes, $seconds);

    $date = new DateTime();

    $date->modify("-" . $totalSeconds . " seconds");

    return $date->format('Y-m-d H:i:s');
}

function includeRouteFiles($folder)
{
    $directory = $folder;
    $handle = opendir($directory);
    $directory_list = [$directory];

    while (false !== ($filename = readdir($handle))) {
        if ($filename != '.' && $filename != '..' && is_dir($directory . $filename)) {
            array_push($directory_list, $directory . $filename . '/');
        }
    }

    foreach ($directory_list as $directory) {
        foreach (glob($directory . '*.php') as $filename) {
            require $filename;
        }
    }
}
