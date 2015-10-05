<?php

namespace EngagementAgency\CDN;

use InvalidArgumentException;

class CDN
{
    const MANIFEST_NAME = 'rev-manifest.json';

    /**
     * @var array
     */
    private $config;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string
     */
    public function asset($asset)
    {
        if ($this->config['BYPASS']) {
            return $asset;
        }
        return $this->config['CDN_URL'] . $asset;
    }

    /**
     * @param string
     */
    public function versioned($asset)
    {
        static $manifest = null;
        if (null === $manifest) {
            $manifest = json_decode(
                file_get_contents(
                    public_path($this->config['BUILD_PATH'] . '/' . self::MANIFEST_NAME)
                ),
                true
            );
        }

        if (isset($manifest[$asset])) {
            $assetPath = '/' . $this->config['BUILD_PATH'] . '/' . ltrim($manifest[$asset], '/');
            return $this->asset($assetPath);
        }

        throw new InvalidArgumentException("File {$asset} not defined in asset manifest.");
    }
}
