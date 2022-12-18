<?php


namespace App\Models\Util;


interface PersistenceObjectInterface
{
    /**
     * 지속성 객체의 지속 상태를 돌려준다. null:지속성 객체 아님, true:지속성 유지, false:지속성 깨짐
     * @return bool|null
     */
    public function getPersistenceState(): ?bool;
}