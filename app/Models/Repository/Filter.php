<?php


namespace App\Models\Repository;


/**
 * 리포지토리 필터
 * class Filter
 * @package App\Models\Repositories
 */
abstract class Filter implements FilterInterface
{
    /** @var Key 엘로퀀트 키 정보 */
    protected $key;

    /**
     * Filtering constructor.
     * @param Key $key
     */
    public function __construct(Key $key)
    {
        $this->key = $key;
    }

    /**
     * @inheritdoc
     * @return Key
     */
    public function getKey(): Key
    {
        return $this->key;
    }
}
