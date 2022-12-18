<?php


namespace App\Models\Repository;


/**
 * 엘로퀀트 키 정보 인터페이스
 * Interface Key
 * @package App\Models\Repositories
 */
interface KeyInterface
{
    /**
     * '엘로퀀트 클래스 이름'을 돌려준다.
     * @return string
     */
    public function getClass(): string;

    /**
     * '컬럼 이름'을 돌려준다.
     * @return string
     */
    public function getColumn(): string;
}
