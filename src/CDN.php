<?php

namespace EngagementAgency\CDN;

use InvalidArgumentException;

class CDN
{
    const ASSET_FOLDER = 'cdn-assets';

    const MANIFEST_NAME = '.manifest.json';

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
        if (null === $manifest) {
            $manifest = json_decode(
                file_get_contents(
                    public_path(self::ASSET_FOLDER . '/' . self::MANIFEST_NAME)
                ),
                true
            );
        }

        if (isset($manifest[$asset])) {
            return $this->cdnUrl . '/build/' . ltrim($manifest[$asset], '/');
        }

        throw new InvalidArgumentException("File {$asset} not defined in asset manifest.");
    }
}
