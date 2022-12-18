<?php


namespace App\Models\Repository;


use App\Values\Code;


/**
 * 정렬 방향성 클래스
 * Class Direction
 * @package App\Models\Repositories
 */
class Direction extends Code
{
    /** @var string 정순 */
    const ASC = 'asc';
    /** @var string 역순 */
    const DESC = 'desc';

    /** @var string[] 유효한 코드 목록 */
    const CODES = [self::ASC, self::DESC];

    /**
     * @inheritdoc
     * @return array
     */
    public static function getCodes(): array
    {
        return static::CODES;
    }
}
