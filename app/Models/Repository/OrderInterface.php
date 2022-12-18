<?php


namespace App\Models\Repository;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;


/**
 * 정렬 정보 인터페이스
 * Interface OrderInterface
 * @package App\Models\Repositories
 */
interface OrderInterface
{
    /**
     * '컬럼명'을 돌려준다.
     * @return Key
     */
    public function getKey(): Key;

    /**
     * '정렬 방향성'을 돌려준다.
     * @return Direction
     */
    public function getDirection(): Direction;

    /**
     * 쿼리를 필터링 한다.
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function apply(EloquentBuilder $query): EloquentBuilder;
}
