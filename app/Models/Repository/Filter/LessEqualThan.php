<?php


namespace App\Models\Repository\Filter;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

use App\Models\Repository\Filter;
use App\Models\Repository\Key;



/**
 * LessEqualThan 조건 필터링 베이스 클래스
 * Class LessEqualThan
 * @package App\Models\Repositories\Filter
 */
abstract class LessEqualThan extends Filter
{
    /** @var mixed */
    protected $value;

    /**
     * LessEqualThan constructor.
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
            '>=',
            is_object($this->value) ? (string)$this->value : $this->value
        );
    }
}
