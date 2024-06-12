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
    if (strpos($duration, 'h') && strpos($duration, 'm') && strpos($duration, 's')) {
        preg_match('/(\d+)h(\d+)m(\d+)s/', $duration, $matches);
        $hours = isset($matches[1]) ? intval($matches[1]) : 0;
        $minutes = isset($matches[2]) ? intval($matches[2]) : 0;
        $seconds = intval($matches[3]);

        $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
    } elseif (strpos($duration, 'm') && strpos($duration, 's')) {
        preg_match('/(\d+)m(\d+)s/', $duration, $matches);
        $hours = 0;
        $minutes = isset($matches[1]) ? intval($matches[2]) : 0;
        $seconds = intval($matches[2]);

        $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
    } else {
        preg_match('/(\d+)s/', $duration, $matches);
        $hours = 0;
        $minutes =  0;
        $seconds = intval($matches[1]);

        $totalSeconds = ($hours * 3600) + ($minutes * 60) + $seconds;
    }

    return $totalSeconds;
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
