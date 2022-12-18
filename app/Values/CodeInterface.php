<?php


namespace App\Values;

/**
 * Code 인터페이스
 * interface CodeInterface
 * @package App\Values
 */
interface CodeInterface
{
    /**
     * '코드' 값을 반환한다.
     * @return mixed
     */
    public function getCode();

    /**
     * 문자열로 변환하여 돌려준다.
     * @return string
     */
    public function __toString(): string;
}
