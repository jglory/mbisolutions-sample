<?php


namespace App\Models\Repository;


/**
 * Repository 명세 표현 인터페이스
 * Interface SpecificationInterface
 * @package App\Models\Repositories
 */
interface SpecificationInterface
{
    /**
     * @return FilterInterface[]
     */
    public function getFilters(): array;
}