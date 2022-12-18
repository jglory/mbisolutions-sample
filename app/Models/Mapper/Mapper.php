<?php


namespace App\Models\Mapper;


/**
 * 객체 맴퍼 베이스 클래스
 * Class Mapper
 * @package App\Models\Mappers
 */
abstract class Mapper implements MapperInterface
{
    /** @var MapperInterface[]  */
    protected $mappers = [];

    /**
     * @inheritdoc
     * @param object $obj
     * @param callable|null $setter
     * @return object
     */
    public function createFrom($obj, ?callable $setter = null)
    {
        $class = get_class($obj);

        /** @var MapperInterface $mapper */
        $key = null;
        if (isset($this->mappers[get_class($obj)])) {
            $key = get_class($obj);
        } else if (isset($this->mappers[gettype($obj)])) {
            $key = gettype($obj);
        }

        if (is_null($key)) {
            throw new \UnexpectedValueException('변환 가능한 매퍼가 없음');
        }

        $mapper = $this->mappers[$key];
        if (is_string($mapper)) {
            $this->mappers[$key] = ($mapper = new $mapper);
        }
        return $mapper->createFrom($obj, $setter);
    }
}
