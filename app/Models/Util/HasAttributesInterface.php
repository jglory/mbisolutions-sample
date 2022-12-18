<?php


namespace App\Models\Util;


/**
 * 속성백 인터페이스
 * Interface HasAttributesInterface
 * @package App\Models\Util
 */
interface HasAttributesInterface
{
    /**
     * 속성 목록을 돌려준다.
     * @return array
     */
    public function getAttributes(): array;

    /**
     * 키값에 해당하는 속성값을 돌려준다.
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * 키값에 연관하여 속성값을 설정한다.
     * @param string $key
     * @param $val
     * @return mixed
     */
    public function setAttribute($key, $val);
}
