<?php

namespace App\Models\Facades;


use Illuminate\Support\Facades\Facade;



/**
 * Eloquent Mapper Facade 클래스
 * Class EloquentMapper
 * @package  App\Models\Facades
 */
class EloquentMapper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return  string
     */
    protected static function getFacadeAccessor()
    {
        return 'mapper.eloquent';
    }
}
