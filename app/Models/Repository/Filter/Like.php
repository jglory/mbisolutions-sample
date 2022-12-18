<?php


namespace App\Models\Repository\Filter;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

use App\Models\Repository\Filter;
use App\Models\Repository\Key;



/**
 * Like 조건 필터링 베이스 클래스
 * Class Like
 * @package App\Models\Repositories\Filter
 */
class Like extends Filter
{
    /** @var mixed */
    protected $value;

    /**
     * Like constructor.
     * @param Key $key
     * @param mixed $value
     */
    public function __construct(Key $key, $value)
    {
        parent::__construct($key);
        $this->value = $value;
    }

    /**
     * @inheritDoc
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function apply(EloquentBuilder $query): EloquentBuilder
    {
        return $query->where(
            $this->key->getColumn(),
            'like',
            $this->value
        );
    }
}
