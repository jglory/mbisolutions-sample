<?php


namespace App\Models\Eloquent;


use App\Models\Eloquent\Model as Eloquent;



/**
 * 엘로퀀트 빌더 인터페이스
 * Interface BuilderInterface
 * @package App\Models\Eloquent
 */
interface BuilderInterface
{
    /**
     * 엔티티를 구성하여 돌려준다.
     * @return Eloquent
     */
    public function build();
}