<?php


namespace App\Models\Mapper;


/**
 * 객체 맵퍼 인터페이스
 * Interface MapperInterface
 * @package App\Models\Mappers
 */
interface MapperInterface
{
    /**
     * 입력된 객체를 기반으로 관련된 다른 객체를 생성하여 돌려준다.
     * @param mixed $obj
     * @param callable|null $setter
     * @return mixed
     */
    public function createFrom($obj, ?callable $setter = null);
}
