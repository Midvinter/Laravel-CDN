<?php

namespace EngagementAgency\CDN;

use Illuminate\Support\Facades\Facade;

class CDNFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CDN::class;
    }
}
