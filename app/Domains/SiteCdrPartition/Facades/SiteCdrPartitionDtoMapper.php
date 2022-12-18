<?php

namespace App\Domains\SiteCdrPartition\Facades;


use Illuminate\Support\Facades\Facade;



/**
 * SiteCdrPartition Dto Mapper Facade 클래스
 * Class SiteCdrPartitionDtoMapper
 * @package  App\Domains\SiteCdrPartition\Facades
 */
class SiteCdrPartitionDtoMapper extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return  string
    */
    protected static function getFacadeAccessor()
    {
        return \App\Domains\SiteCdrPartition\Mappers\Dtos\SiteCdrPartition::class;
    }
}
