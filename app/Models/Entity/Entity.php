<?php


namespace App\Models\Entity;


use App\Models\Dto\Dto;
use App\Models\Util\HasAttributesInterface;
use App\Models\Util\PersistenceObjectInterface;
use App\Models\Util\PersistenceObjectTrait;


/**
 * 엔티티 클래스
 * Class Entity
 * @package App\Models\Entity
 */
abstract class Entity implements EntityInterface, PersistenceObjectInterface
{
    use PersistenceObjectTrait;

    /** @var Dto */
    protected $dto;

    /**
     * Entity constructor.
     * @param Dto $dto
     * @param bool|null $persistenceState
     */
    public function __construct($dto, ?bool $persistenceState = null)
    {
        $this->dto = $dto;
        $this->persistenceState = $persistenceState;
    }

    /**
     * 고유키의 값을 돌려준다.
     * @return int
     */
    public function getKey(): int
    {
        return $this->dto->getKey();
    }

    /**
     * 고유키의 이름을 돌려준다.
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->dto->getKeyName();
    }

    /**
     * 객체를 복제한다.
     */
    public function __clone()
    {
        $this->dto = clone $this->dto;
    }

    /**
     * Dto를 돌려준다.
     * @return mixed
     */
    public function getDto()
    {
        return clone $this->dto;
    }
}
