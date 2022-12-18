<?php


namespace App\Domains\SiteCdrPartition\Values;


use App\Values\Code;



/**
 * @OA\Schema(
 *      schema="Domains-SiteCdrPartition-Values-Type",
 *      @OA\Property(property="code", type="string", default="I", enum={"I", "O"}, description="타입. I:인바운드, O:아웃바운드", example="I")
 * )
 *
 * '타입' 값객체 클래스
 * Class Type
 * @package App\Domains\SiteCdrPartition\Values
 */
class Type extends Code
{
    /** @var string 인바운드 */
    const INBOUND = 'I';
    /** @var string 아웃바운드 */
    const OUTBOUND = 'O';


    /** @var string[] 유효한 코드 목록 */
    const CODES = [self::INBOUND, self::OUTBOUND,];
    /** @var string[] 코드에 해당하는 이름 목록 */
    const NAMES = [
        self::INBOUND => '인바운드',
        self::OUTBOUND => '아웃바운드',
        ];

    /**
     * @inheritDoc
     * @return array
     */
    public static function getCodes(): array
    {
        return self::CODES;
    }

    /**
     * '코드에 해당하는 이름 목록'을 돌려준다.
     * @return array
     */
    public static function getNames(): array
    {
        return self::NAMES;
    }
}