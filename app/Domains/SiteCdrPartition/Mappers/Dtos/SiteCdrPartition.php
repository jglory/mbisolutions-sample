<?php

namespace App\Domains\SiteCdrPartition\Mappers\Dtos;

use App\Models\Mapper\Mapper;

use App\Domains\SiteCdrPartition\Eloquents\SiteCdrPartition as SiteCdrPartitionEloquent;

use App\Domains\SiteCdrPartition\Mappers\Dtos\Mappers\SiteCdrPartitionEloquent as SiteCdrPartitionEloquentMapper;



/**
 * SiteCdrPartition Dto Mapper 클래스
 * Class SiteCdrPartition
 * @package  App\Domains\SiteCdrPartition\Mappers\Dtos
 */
class SiteCdrPartition extends Mapper
{
    protected $mappers = [
        SiteCdrPartitionEloquent::class => SiteCdrPartitionEloquentMapper::class,
    ];
}
