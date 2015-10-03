<?php

namespace EngagementAgency\CDN\Commands;

use EngagementAgency\CDN\CDN;
use Illuminate\Console\Command;
use Symfony\Component\Filesystem\Filesystem;

class Version extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdn:version';

    /**
     * The package config
     *
     * @var array
     */
    protected $config;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Versions the assets specified in the asset list';

    /**
     * Create a new command instance.
     *
     * @param array
     * @return void
     */
    public function __construct(array $config)
    {
        parent::__construct();
        $this->config = $config;
    }

    /**
     * Returns the extension of a file
     *
     * @return string
     */
    private static function extension($name)
    {
        return strrchr($name, '.');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        static $config = null;
        if (null === $config) {
            $assetList = json_decode(
                file_get_contents($this->config['ASSET_LIST_PATH']),
                true
            );
        }

        $fs = new Filesystem();
        $map = [];
        foreach ($assetList as $source) {
            $sourcePath = public_path(ltrim($source, '/'));
            $hash = substr(hash_file('md5', $sourcePath), 0, 10);
            $relativeSourcePath = trim(
                $fs->makePathRelative($sourcePath, public_path()),
                '/'
            );
            $extension = self::extension($sourcePath);
            $relativeToBuildTargetPath = substr(
                $relativeSourcePath,
                0,
                -strlen($extension)
            ) . '-' . $hash . $extension;
            $relativeToPublicTargetPath = $this->config['BUILD_PATH'] . '/' . $relativeToBuildTargetPath;
            $targetPath = public_path($relativeToPublicTargetPath);
            $fs->copy($sourcePath, $targetPath);
            $this->info(
                "$relativeSourcePath has been copied to $relativeTargetPath"
            );
            $map[$relativeSourcePath] = $relativeToBuildTargetPath;
        }

        $relativeManifestPath = $this->config['BUILD_PATH'] . '/' . CDN::MANIFEST_NAME;
        $manifestPath = public_path($relativeManifestPath);
        $fs->dumpFile($manifestPath, json_encode($map));
        $this->info("Manifest has been written to $relativeManifestPath");
    }
}
