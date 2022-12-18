<?php

namespace App\Models\Facades;


use Illuminate\Support\Facades\Facade;



/**
 * Dto Mapper Facade 클래스
 * Class DtoMapper
 * @package  App\Models\Facades
 */
class DtoMapper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return  string
     */
    protected static function getFacadeAccessor()
    {
        return 'mapper.dto';
    }
}
