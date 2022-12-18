<?php


namespace App\Models\Repository;


/**
 * 엘로퀀트 키 정보
 * Class Key
 * @package App\Models\Repositories
 */
class Key implements KeyInterface, \JsonSerializable
{
    /** @var string 엘로퀀트 클래스 이름 */
    protected $class;
    /** @var string 컬럼 이름 */
    protected $column;

    /**
     * Key constructor.
     * @param string $class
     * @param string $column
     */
    public function __construct(string $class, string $column)
    {
        $this->class = $class;
        $this->column = $column;
    }

    /**
     * '엘로퀀트 클래스 이름'을 돌려준다.
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * '컬럼 이름'을 돌려준다.
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'class' => $this->class,
            'column' => $this->column,
        ];
    }
}
