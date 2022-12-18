<?php


namespace App\Http\Transformers;

/**
 * 트랜스포머 인터페이스
 * Interface TransformerInterface
 * @package App\Http\Transformers
 */
interface TransformerInterface
{
    /**
     * 입력 데이터를 변환 처리를 하여 돌려준다.
     * @param mixed $data
     * @return mixed
     */
    public function process($data);
}