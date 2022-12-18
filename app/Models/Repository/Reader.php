<?php


namespace App\Models\Repository;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

use App\Models\Repository\FilterInterface;
use App\Models\Repository\OrderInterface;
use App\Models\Repository\PagerInterface;
use App\Models\Repository\Pager;


/**
 * 읽기 리포지토리 클래스
 * Class Reader2
 * @package App\Models\Repositories
 */
abstract class Reader implements ReaderInterface
{
    /**
     * 스키마 정보를 돌려준다.
     *  스키마 정보
     *  [
     *      'eloquents' => [
     *          RootEloquent::class,
     *          SubEloquent::class
     *      ],
     *      'relations' => [
     *          [
     *              'class' => RootEloquent::class,
     *              'with' => 'subEloquents',
     *          ],
     *      ],
     *  ]
     *
     */
    abstract public static function getSchema();

    /**
     * @param mixed $eloq
     * @return mixed
     */
    abstract protected function createAggregate($eloq);

    /**
     * 쿼리빌더 객체를 만든다.
     * @param SpecificationInterface|null $spec
     * @param PagerInterface|null $paging
     * @param OrderInterface|OrderInterface[] $orderings
     * @return EloquentBuilder
     */
    protected function makeQuery(?SpecificationInterface $spec = null, ?PagerInterface $paging = null, $orderings = []): EloquentBuilder
    {
        if ($orderings instanceof OrderInterface) {
            $orderings = [$orderings];
        }

        $schema = static::getSchema();

        /** @var FilterInterface $filtering */
        $filteringMap = [];
        foreach ($schema['eloquents'] as $class) {
            $filteringMap[$class] = [];
        }
        if (is_null($spec)===false) {
            foreach ($spec->getFilters() as $filtering) {
                $filteringMap[$filtering->getKey()->getClass()][] = $filtering;
            }
        }

        $rootClass = $schema['eloquents'][0];

        /** @var EloquentBuilder $query */
        $query = $rootClass::query();
        foreach ($orderings as $ordering) {
            $ordering->apply($query);
        }
        foreach ($filteringMap[$rootClass] as $filtering) {
            $filtering->apply($query);
        }
        if (is_null($paging)==false) {
            $paging->apply($query);
        }

        foreach ($schema['relations'] as $item) {
            $filterings = $filteringMap[$item['class']];
            $query->with([$item['with'] => function ($query) use (&$filterings) {
                /** @var FilterInterface $filtering */
                foreach ($filterings as $filtering) {
                    $filtering->apply($query);
                }
            }]);
        }

        return $query;
    }

    /**
     * @inheritdoc
     * @param SpecificationInterface|null $spec
     * @return int
     */
    public function count(?SpecificationInterface $spec = null): int
    {
        return $this->makeQuery($spec)->count();
    }

    /**
     * @inheritdoc
     * @param SpecificationInterface|null $spec
     * @return bool
     */
    public function exists(?SpecificationInterface $spec = null): bool
    {
        return $this->count($spec)>0;
    }

    /**
     * @inheritdoc
     * @param SpecificationInterface|null $spec
     * @param PagerInterface|null $pager
     * @param OrderInterface|OrderInterface[] $orders
     * @return array
     */
    public function find(?SpecificationInterface $spec = null, ?PagerInterface $pager = null, $orders = []): array
    {
        $result = [];
        foreach ($this->makeQuery($spec, $pager, $orders)->get() as $eloq) {
            $result[] = $this->createAggregate($eloq);
        }
        return $result;
    }

    /**
     * @inheritdoc
     * @param SpecificationInterface|null $spec
     * @param OrderInterface|OrderInterface[] $orderings
     * @return mixed|null
     */
    public function findFirst(?SpecificationInterface $spec = null, $orderings = [])
    {
        $result = $this->find($spec, new Pager(1, 1), $orderings);
        return empty($result) ? null : $result[0];
    }
}
