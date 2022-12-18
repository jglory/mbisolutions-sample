<?php


namespace App\Models\Transformer;

/**
 * 처리를 하지 않는 트랜스포머 클래스
 * Class BypassTransformer
 * @package App\Models\Transformers
 */
class BypassTransformer extends Transformer
{
    /**
     * @inheritDoc
     * @param array $data
     * @throws \Exception
     */
    public function process($data)
    {
        return $data;
    }
}
