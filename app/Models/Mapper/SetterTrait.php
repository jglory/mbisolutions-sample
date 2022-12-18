<?php


namespace App\Models\Mapper;


/**
 * 추가 세팅 수행 트레이트
 * Trait SetterTrait
 * @package App\Models\Mappers
 */
trait SetterTrait
{
    /**
     * @param mixed $obj
     * @param callable|null $setter
     * @return mixed
     */
    protected function applySetter($obj, ?callable $setter = null)
    {
        if (is_null($setter)==false) {
            $obj = $setter($obj);
        }
        return $obj;
    }
}
