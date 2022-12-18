<?php


namespace App\Http\Transformers;


/**
 * bypass 트랜스포머 베이스 클래스
 * Class Transformer
 * @package App\Http\Transformers
 */
abstract class BypassTransformer extends Transformer
{
    /**
     * @inheritDoc
     * @param mixed $data
     * @return mixed
     */
    public function process($data)
    {
        return $data;
    }
}