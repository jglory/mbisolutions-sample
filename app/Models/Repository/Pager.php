<?php


namespace App\Models\Repository;


use Illuminate\Database\Eloquent\Builder as EloquentBuilder;


/**
 * 페이징 정보 클래스
 * Class Pager
 * @package App\Models\Repositories
 */
class Pager implements PagerInterface, \JsonSerializable
{
    /** @var int 페이지 번호 */
    protected $pageNo;
    /** @var int 페이지 당 아이템 갯수 */
    protected $itemCountPerPage;

    /**
     * Pager constructor.
     * @param int $pageNo
     * @param int $itemCountPerPage
     */
    public function __construct(int $pageNo, int $itemCountPerPage)
    {
        $this->pageNo = $pageNo;
        $this->itemCountPerPage = $itemCountPerPage;
    }

    /**
     * @inheritdoc
     * @return int
     */
    public function getPageNo(): int
    {
        return $this->pageNo;
    }

    /**
     * @inheritdoc
     * @return int
     */
    public function getItemCountPerPage(): int
    {
        return $this->itemCountPerPage;
    }

    /**
     * @inheritdoc
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'pageNo' => $this->pageNo,
            'itemCountPerPage' => $this->itemCountPerPage
        ];
    }

    /**
     * @inheritdoc
     * @param EloquentBuilder $query
     * @return EloquentBuilder
     */
    public function apply(EloquentBuilder $query): EloquentBuilder
    {
        return $query->skip(($this->getPageNo()-1)*$this->getItemCountPerPage())
            ->take($this->getItemCountPerPage());
    }
}
