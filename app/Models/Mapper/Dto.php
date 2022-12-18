<?php

namespace App\Models\Mapper;


use Closure;

use Illuminate\Support\Collection;

use App\Models\Dto\Dto as DtoBase;
use App\Models\Eloquent\Model as EloquentBase;

use App\Transformers\TransformerInterface;



class Dto implements TransformerInterface
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
     * @param EloquentBase $eloquent
     * @return DtoBase
     */
    private function getDto($eloquent)
    {
        if (is_object($eloquent)===false || $eloquent instanceof EloquentBase===false) {
            throw new \UnexpectedValueException('비정상적인 입력값입니다.');
        }

        $class = get_class($eloquent);
        if (isset($this->mappings[$class])===false) {
            throw new \UnexpectedValueException(get_class($eloquent).' 연관된 변환 정보를 찾을 수 없습니다.');
        }

        return new $this->mappings[$class];
    }

    /**
     * @inheritdoc
     * @param EloquentBase $eloquent
     * @return DtoBase
     */
    public function process($eloquent)
    {
        $dto = $this->getDto($eloquent);
        foreach ($eloquent->getAttributeNames() as $key) {
            $dto->{$key} = $eloquent->{$key};
        }

        foreach (array_keys($eloquent->getRelations()) as $key) {
            if ($eloquent->{$key} instanceof Collection) {
                $dto->{$key} = $eloquent->{$key}->map(
                    Closure::bind(
                        function (EloquentBase $item) {
                            return $this->process($item);
                        },
                        $this
                    )
                );
            } else {
                $dto->{$key} = $this->process($eloquent->{$key});
            }
        }

        return $dto;
    }
}