<?php


namespace App\Domains\SiteCdrPartition\Values;


use App\Values\Code;



/**
 * @OA\Schema(
 *      schema="Domains-SiteCdrPartition-Values-Cause",
 *      @OA\Property(property="code", type="string", enum={"0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "Q", "Z"}, description="불완료 통화 코드. 0:통화중, 1:응답없음, 2:결번, 3:발신자 전화 끊음, 4:거절, 5:전원꺼짐, 6:고객 통화중, 7:고객 부재중, 8:고객 결번, 9:고객 거절, Q:성공, Z:기타", example="01")
 * )
 *
 * '불완료 통화 코드' 값객체 클래스
 * Class Cause
 * @package App\Domains\SiteCdrPartition\Values
 */
class Cause extends Code
{
    /** @var string 기타 */
    const ETC = '0';
    /** @var string 응답없음 */
    const NO_RESPONSE = '1';
    /** @var string 결번 */
    const WRONG_NUMBER = '2';
    /** @var string 발신자 전화 끊음 */
    const HUNG_UP = '3';
    /** @var string 거절 */
    const REJECTED = '4';
    /** @var string 전원꺼짐 */
    const POWER_OFF = '5';
    /** @var string 성공 */
    const CONNECTED = 'Q';
    /** @var string 통화중 */
    const BUSY = 'Z';
    /** @var string 고객 통화중 */
    const OUTBOUND_BUSY = '6';
    /** @var string 고객 부재중 */
    const OUTBOUND_NO_RESPONSE = '7';
    /** @var string 고객 결번 */
    const OUTBOUND_WRONG_NUMBER = '8';
    /** @var string 고객 거절 */
    const OUTBOUND_REJECTED = '9';
    /** @var string 고객 전원꺼짐 */
    const OUTBOUND_POWER_OFF = 'F';

    /** @var string[] 유효한 코드 목록 */
    const CODES = [self::ETC, self::NO_RESPONSE, self::WRONG_NUMBER, self::HUNG_UP, self::REJECTED, self::POWER_OFF, self::CONNECTED, self::BUSY,
        self::OUTBOUND_NO_RESPONSE, self::OUTBOUND_WRONG_NUMBER, self::OUTBOUND_REJECTED, self::OUTBOUND_POWER_OFF, self::OUTBOUND_BUSY];

    /**
     * @inheritDoc
     * @return array
     */
    public static function getCodes(): array
    {
        return self::CODES;
    }
}