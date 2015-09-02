<?php

$bypass = env('MIDVINTER_CDN_BYPASS', null);
if ($bypass === null) {
    $bypass = env('APP_DEBUG', false);
}

return [

    /**
     * These config variables are mandatory
     */
    'BYPASS'    => env('MIDVINTER_CDN_BYPASS', null),
    'CDN_URL'   => env('MIDVINTER_CDN_URL', null)

];
