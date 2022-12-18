<?php


namespace App\Models\Repository;


use App\Values\Code;


/**
 * 엘로퀀트 연결 타입 정보
 * Class RelationType
 * @package App\Models\Repository
 */
class RelationType extends Code
{
    /** @var string */
    const HAS_ONE = 'hasOne';
    /** @var string */
    const HAS_MANY = 'hasMany';


    /** @var string[] 유효한 코드 목록 */
    const CODES = [self::HAS_ONE, self::HAS_MANY];

    /**
     * @inheritdoc
     * @return array
     */
    public static function getCodes(): array
    {
        return static::CODES;
    }
}
