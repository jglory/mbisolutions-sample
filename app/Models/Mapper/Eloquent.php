<?php

namespace App\Models\Mapper;


use Closure;

use Illuminate\Support\Collection;

use App\Models\Dto\Dto as DtoBase;
use App\Models\Eloquent\Model as EloquentBase;

use App\Transformers\TransformerInterface;



class Eloquent implements TransformerInterface
{
    private $mappings = [];

    /**
     * @param array $mappings
     */
    public function __construct(array $mappings)
    {
        $this->mappings = $mappings;
    }

    /**
     * @param DtoBase $dto
     * @return EloquentBase
     */
    private function getEloquent($dto)
    {
        if (is_object($dto)===false || $dto instanceof DtoBase===false) {
            throw new \UnexpectedValueException('비정상적인 입력값입니다.');
        }

        $class = get_class($dto);
        if (isset($this->mappings[$class])===false) {
            throw new \UnexpectedValueException(get_class($dto).' 연관된 변환 정보를 찾을 수 없습니다.');
        }

        return new $this->mappings[$class];
    }

    /**
     * @inheritdoc
     * @param DtoBase $dto
     * @return EloquentBase
     */
    public function process($dto)
    {
        $eloquent = $this->getEloquent($dto);
        $eloquentKeys = $eloquent->getAttributeNames();
        foreach ($dto->getAttributeNames() as $key) {
            if (in_array($key, $eloquentKeys)) {
                $eloquent->{$key} = $dto->{$key};
            } else {
                if (is_null($dto->{$key})) {
                    continue;
                }

                if ($dto->{$key} instanceof Dto) {
                    $eloquent->setRelation($key, $this->process($dto->{$key}));
                } elseif ($dto->{$key} instanceof Collection) {
                    $eloquent->setRelation(
                        $key,
                        $dto->{$key}->map(
                            Closure::bind(
                                function ($item) {
                                    return $this->process($item);
                                },
                                $this
                            )
                        )
                    );
                } else {
                    throw new \LogicException('변환 불가능한 데이터가 존재합니다.');
                }
            }
        }

        return $eloquent;
    }
}