<?php


namespace App\Models\Repository;


/**
 * Repository 명세 표현 클래스
 * Interface Specification
 * @package App\Models\Repositories
 */
abstract class Specification implements SpecificationInterface
{
    /** @var FilterInterface[]  */
    protected $filters = [];

    /**
     * Specification constructor.
     * @param array $filters
     */
    protected function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return FilterInterface[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }
}