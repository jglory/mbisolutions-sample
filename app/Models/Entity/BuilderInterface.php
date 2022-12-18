<?php


namespace App\Models\Entity;


/**
 * 엔티티 빌더 인터페이스
 * Interface BuilderInterface
 * @package App\Models\Entity
 */
interface BuilderInterface
{
    /**
     * 엔티티를 구성하여 돌려준다.
     * @return EntityInterface
     */
    public function build();
}