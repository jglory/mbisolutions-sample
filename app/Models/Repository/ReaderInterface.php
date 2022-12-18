<?php


namespace App\Models\Repository;


use App\Models\Repository\FilterInterface;
use App\Models\Repository\OrderInterface;
use App\Models\Repository\Pager;
use App\Models\Repository\PagerInterface;


/**
 * Interface ReaderInterface
 * @package App\Models\Repositories
 */
interface ReaderInterface
{
    /**
     * 조건에 해당하는 데이터의 개수를 돌려준다.
     * @param SpecificationInterface|null $spec
     * @return int
     */
    public function count(?SpecificationInterface $spec = null): int;

    /**
     * 조건에 해당하는 데이터의 존재여부 돌려준다.
     * @param SpecificationInterface|null $spec
     * @return bool
     */
    public function exists(?SpecificationInterface $spec = null): bool;

    /**
     * 조건에 해당하는 데이터를 돌려준다.
     * @param SpecificationInterface|null $spec
     * @param PagerInterface|null $paging
     * @param OrderInterface|OrderInterface[] $orderings
     * @return array
     */
    public function find(?SpecificationInterface $spec = null, ?PagerInterface $paging = null, $orderings = []): array;

    /**
     * 조건에 해당하는 첫번째 데이터를 돌려준다.
     * @param SpecificationInterface|null $spec
     * @param OrderInterface|OrderInterface[] $orderings
     * @return mixed|null
     */
    public function findFirst(?SpecificationInterface $spec = null, $orderings = []);
}
