<?php


namespace App\Models\Util;


/**
 * 지속성 객체 트레이트
 * Trait PersistenceObjectTrait
 * @package App\Models\Util
 */
trait PersistenceObjectTrait
{
    /** @var bool|null 지속성 상태. null:지속성 객체 아님, true:지속성 유지, false:지속성 깨짐 */
    protected $persistenceState;

    /**
     * 객체의 지속성 상태를 갱신한다.
     */
    protected function updatePersistenceState()
    {
        if (is_null($this->persistenceState)===false) {
            $this->persistenceState = false;
        }
    }

    /**
     * 객체의 지속성 상태를 돌려준다.
     * @return bool|null
     */
    public function getPersistenceState(): ?bool
    {
        return $this->persistenceState;
    }
}