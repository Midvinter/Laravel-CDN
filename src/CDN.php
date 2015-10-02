<?php

namespace EngagementAgency\CDN;

use InvalidArgumentException;

class CDN
{
    /**
     * @var string
     */
    private $cdnUrl;

    /**
     * @var bool
     */
    private $bypass;

    public function __construct($config = [])
    {
        $this->cdnUrl = rtrim($config['CDN_URL'], '/');
        if ($config['BYPASS'] === null) {
            $config['BYPASS'] = env('APP_DEBUG', false);
        }
        $this->bypass = $config['BYPASS'];
    }

    /**
     * @param string
     */
    public function asset($asset)
    {
        if ($this->bypass) {
            return asset($asset);
        }

        static $manifest = null;

        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('cdn-assets/.manifest.json')), true);
        }

        if (isset($manifest[$file])) {
            return $this->cdnUrl . '/build/' . ltrim($manifest[$file], '/');
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}
