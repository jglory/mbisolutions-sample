<?php


namespace App\Models\Repository\Filter;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

use App\Models\Repository\Filter;
use App\Models\Repository\Key;



/**
 * NotBetween 조건 필터링 베이스 클래스
 * Class NotBetween
 * @package App\Models\Repositories\Filter
 */
abstract class NotBetween extends Filter
{
    /** @var mixed 시작자료 */
    protected $begin;
    /** @var mixed 종료자료 */
    protected $end;

    /**
     * NotBetween constructor.
     * @param Key $key
     * @param mixed $begin
     * @param mixed $end
     */
    public function __construct(Key $key, $begin, $end)
    {
        parent::__construct($key);
        $this->begin = $begin;
        $this->end = $end;
    }

    /**
     * @inheritDoc
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function apply(EloquentBuilder $query): EloquentBuilder
    {
        return $query->whereNotBetween(
            $this->key->getColumn(),
            [
                is_object($this->begin) ? (string)$this->begin : $this->begin,
                is_object($this->end) ? (string)$this->end : $this->end
            ]
        );
    }
}
