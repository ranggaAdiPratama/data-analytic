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
// NOTE get user field id
function myFieldId()
{
    $identifier = DB::table('users')
        ->join('user_details', 'user_details.user_id', '=', 'users.id')
        ->select([
            'users.id', 'users.name', 'users.username',
            'users.email', 'users.deleted_at', 'user_details.field_id',
            'user_details.signature'
        ])
        ->where('users.id', auth('api')->user()->id)
        ->first();

    $field = DB::table('fields')
        ->whereNull('deleted_at')
        ->where('id', $identifier->field_id)
        ->first();

    return $field ? $field->id : '';
}
// NOTE routing
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
// NOTE string to array
function stringtoArray($string)
{
    $hay    = [
        '[', ']', '"'
    ];

    $data   = str_replace($hay, '', $string);

    $data   = explode(',', $data);

    return $data;
}
