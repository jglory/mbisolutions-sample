<?php


namespace App\Models\Entity;


/**
 * 엔티티 인터페이스
 * Interface EntityInterface
 * @package App\Models\Entity
 */
interface EntityInterface
{
    /**
     * 고유키의 이름을 돌려준다.
     * @return string
     */
    public function getKeyName(): string;

    /**
     * 고유키의 값을 돌려준다.
     * @return int
     */
    public function getKey(): int;
}
