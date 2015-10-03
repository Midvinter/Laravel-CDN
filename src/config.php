<?php

$bypass = env('ENGAGEMENT_CDN_BYPASS', null);
if ($bypass === null) {
    $bypass = env('APP_DEBUG', false);
}

return [

    /**
     * The relative path of the asset list. Relative to the project root
     */
    'ASSET_LIST_PATH' => env(
        'ENGAGEMENT_CDN_ASSET_LIST_PATH',
        config_path('engagement-cdn.json')
    ),

    'BUILD_PATH'        => env('ENGAGEMENT_CDN_BUILD_PATH', 'cdn-assets'),
    'BYPASS'            => env('ENGAGEMENT_CDN_BYPASS', null),

    /**
     * These config variables are mandatory
     */
    'CDN_URL'   => env('ENGAGEMENT_CDN_URL', null)

];
