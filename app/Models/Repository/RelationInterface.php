<?php


namespace App\Models\Repository;


/**
 * 엘로퀀트 연결 정보 인터페이스
 * Class Relation
 * @package App\Models\Repositories
 */
interface RelationInterface
{
    /**
     * '연관키' 배열을 돌려준다.
     * @return Key[]
     */
    public function getKeys(): array;

    /**
     * '연관키 A'을 돌려준다.
     * @return Key
     */
    public function getA(): Key;

    /**
     * '연관키 B'을 돌려준다.
     * @return Key
     */
    public function getB(): Key;
}
