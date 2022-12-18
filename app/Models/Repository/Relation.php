<?php


namespace App\Models\Repository;


/**
 * 엘로퀀트 연결 정보
 * Class Relation
 * @package App\Models\Repositories
 */
class Relation implements RelationInterface, \JsonSerializable
{
    /** @var Key[] 연관키 배열 */
    protected $keys = [
        0 => null,
        1 => null,
    ];

    /**
     * Relation constructor.
     * @param Key $a
     * @param Key $b
     */
    public function __construct(Key $a, Key $b)
    {
        $this->keys[0] = $a;
        $this->keys[1] = $b;
    }

    /**
     * '연관키' 배열을 돌려준다.
     * @return Key[]
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * '연관키 A'을 돌려준다.
     * @return Key
     */
    public function getA(): Key
    {
        return $this->keys[0];
    }

    /**
     * '연관키 B'을 돌려준다.
     * @return Key
     */
    public function getB(): Key
    {
        return $this->keys[1];
    }

    /**
     * @inheritdoc
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return [
            'a' => $this->keys[0]->jsonSerialize(),
            'b' => $this->keys[1]->jsonSerialize(),
        ];
    }
}
