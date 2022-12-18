<?php


namespace App\Models\Repository;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;


/**
 * Interface PagerInterface
 * @package App\Models\Repositories
 */
interface PagerInterface
{
    /**
     * '페이지 번호'를 돌려준다.
     * @return int
     */
    public function getPageNo(): int;

    /**
     * '페이지 당 아이템 갯수'를 돌려준다.
     * @return int
     */
    public function getItemCountPerPage(): int;

    /**
     * 쿼리를 필터링 한다.
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function apply(EloquentBuilder $query): EloquentBuilder;
}
