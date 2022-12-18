<?php


namespace App\Domains\SiteCdrPartition\Values;


use App\Values\Code;



/**
 * @OA\Schema(
 *      schema="Domains-SiteCdrPartition-Values-Result",
 *      @OA\Property(property="code", type="string", enum={"00", "01", "02", "99"}, description="시나리오 타입 코드. O0:실패, 01:정상, 02:서비스 전달, 99:중복", example="01")
 * )
 *
 * '통화결과 코드' 값객체 클래스
 * Class Result
 * @package App\Domains\SiteCdrPartition\Values
 */
class Result extends Code
{
    /** @var string 실패 */
    const FAIL = '00';
    /** @var string 정상 */
    const SUCCESS = '01';
    /** @var string 서비스 연결 */
    const SERVICE_FORWARDING = '02';
    /** @var string 중복 */
    const DUPLICATED = '99';

    /** @var string[] 유효한 코드 목록 */
    const CODES = [self::FAIL, self::SUCCESS, self::SERVICE_FORWARDING, self::DUPLICATED];

    /**
     * @inheritDoc
     * @return string[]
     */
    public static function getCodes(): array
    {
        return self::CODES;
    }
}