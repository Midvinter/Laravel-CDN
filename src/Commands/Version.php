<?php

namespace EngagementAgency\CDN\Commands;

use EngagementAgency\CDN;
use Illuminate\Console\Command;
use Symfony\Component\Filesystem\Filesystem;

class Stub extends Command
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

        $assetFolder =
        $fs = new Filesystem();
        $map = [];
        foreach ($assetList as $source) {
            $sourcePath = public_path(ltrim($source, '/'));
            $hash = file_hash('sha1', $sourcePath);
            $relativeSourcePath = $fs->makePathRelative(public_path(), $sourcePath);
            $relativeTargetPath = './' . CDN::ASSET_FOLDER . '/' . $hash . '/' . ltrim($relativeSourcePath, '/');
            $targetPath = realpath($relativeTargetPath);
            $fs->copy($sourcePath, $targetPath);
            $map[$relativeSourcePath] = $relativeTargetPath;
        }

        $fs->dumpFile(
            public_path(CDN::ASSET_FOLDER . '/' . CDN::MANIFEST_NAME),
            json_encode($map)
        );
    }
}