<?php


namespace App\Models\Repository;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;


/**
 * 정렬 정보 클래스
 * Class Order
 * @package App\Models\Repositories
 */
abstract class Order implements OrderInterface, \JsonSerializable
{
    /** @var Key 엘로퀀트 키 정보 */
    protected $key;
    /** @var Direction 정렬 방향성 */
    protected $direction;

    /**
     * Order constructor.
     * @param Key $key
     * @param Direction|null $direction
     */
    public function __construct(Key $key, ?Direction $direction = null)
    {
        $this->key = $key;
        $this->direction = $direction ?? new Direction(Direction::ASC);
    }

    /**
     * '엘로퀀트 키 정보'을 돌려준다.
     * @return Key
     */
    public function getKey(): Key
    {
        return $this->key;
    }

    /**
     * '정렬 방향성'을 돌려준다.
     * @return Direction
     */
    public function getDirection(): Direction
    {
        return $this->direction;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'key' => $this->key->jsonSerialize(),
            'direction' => $this->direction->jsonSerialize()
        ];
    }

    /**
     * @inheritdoc
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function apply(EloquentBuilder $query): EloquentBuilder
    {
        return $query->orderBy($this->key->getColumn(), (string)$this->direction);
    }
}
