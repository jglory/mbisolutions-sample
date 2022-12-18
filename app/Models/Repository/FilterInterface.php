<?php


namespace App\Models\Repository;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use App\Models\Repository\Key;


/**
 * 리포지토리 필터 인터페이스
 * Interface FilterInterface
 * @package App\Models\Repositories
 */
interface FilterInterface
{
    /**
     * '키 정보'를 돌려준다.
     * @return Key
     */
    public function getKey(): Key;

    /**
     * 쿼리를 필터링 한다.
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function apply(EloquentBuilder $query): EloquentBuilder;
}
