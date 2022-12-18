<?php


namespace App\Http\Transformers;


/**
 * 트랜스포머 베이스 클래스
 * Class Transformer
 * @package App\Http\Transformers
 */
abstract class Transformer implements TransformerInterface
{
    /**
     * @inheritDoc
     * @param mixed $data
     * @return null
     */
    public function process($data)
    {
        return null;
    }
}