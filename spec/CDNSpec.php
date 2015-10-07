<?php namespace spec\EngagementAgency\CDN;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;

class CDNSpec extends ObjectBehavior
{
    public function let()
    {
        vfsStreamWrapper::register();
    }

    public function letGo()
    {
        vfsStreamWrapper::unregister();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(EngagementAgency\CDN\CDN::class);
    }

    public function it_provides_asset_file_path_without_cdn()
    {

    }

}
