<?php

namespace Midvinter\CDN;

use Blue\Tools\Api\Client as BSDToolsClient;
use InvalidArgumentException;

class CDN {

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
        $this->bypass = $config['BYPASS'];
    }

    /**
     * @param string
     */
    public function asset($asset) {
        if ($this->bypass) {
            return $asset;
        }
        return $this->cdnUrl . '/' . ltrim($asset, '/');
    }

}