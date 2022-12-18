<?php

namespace App\Domains\SiteCdrPartition\Mappers\Dtos\Mappers;


use App\Models\Mapper\MapperInterface;
use App\Models\Mapper\SetterTrait;

use App\Domains\SiteCdrPartition\Dtos\SiteCdrPartition as SiteCdrPartitionDto;



/**
* Class SiteCdrPartitionEloquent
* @package  App\Domains\SiteCdrPartition\Mappers\Dtos\Mappers
*/
class SiteCdrPartitionEloquent implements MapperInterface
{
    use SetterTrait;

    /**
    * @inheritdoc
    * @param  \App\Domains\SiteCdrPartition\Eloquents\SiteCdrPartition $eloquent
    * @param  callable|null $setter
    * @return  mixed
    */
    public function createFrom($eloquent, ?callable $setter = null)
    {
        $dto = new SiteCdrPartitionDto();
        foreach ($dto->getAttributeNames() as $key) {
            $dto->$key = $eloquent->getAttribute($key);
        }
        return $this->applySetter($dto, $setter);
    }
}
