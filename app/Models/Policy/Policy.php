<?php


namespace App\Models\Policy;



/**
 * '정책' 객체 베이스 클래스
 * Class Policy
 * @package App\Models\Policy
 */
abstract class Policy
{
    /**
     * @return mixed
     */
    abstract public function apply($target);
}