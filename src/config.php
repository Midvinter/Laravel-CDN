<?php

$bypass = env('ENGAGEMENT_CDN_BYPASS', null);
if ($bypass === null) {
    $bypass = env('APP_DEBUG', false);
}

return [

    /**
     * These config variables are mandatory
     */
    'BYPASS'    => env('ENGAGEMENT_CDN_BYPASS', null),
    'CDN_URL'   => env('ENGAGEMENT_CDN_URL', null)

];
