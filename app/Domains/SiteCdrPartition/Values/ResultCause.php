<?php


namespace App\Domains\SiteCdrPartition\Values;


use App\Values\Code;



/**
 * @OA\Schema(
 *      schema="App.Domains.SiteCdrPartition.Values.ResultCause",
 *      @OA\Property(property="code", type="string",
 *          enum={"00", "01", "02", "03", "04", "05", "0Q", "0Z", "10", "11", "12", "13", "1Q", "1Z", "90", "91", "92", "93", "9Q", "9Z", "20", "21", "22", "23", "24", "25", "26", "27", "28"},
 *          description="호정보 완료 통합 코드. 00:콜연결 실패(연결지연), 01:콜연결 실패(결번), 02:콜연결 실패(결번), 03:안내(정보청취), 04:콜연결 실패(전화거절), 05:콜연결 실패(전원꺼짐), 0Q:콜연결 실패(알수없음), 0Z:콜연결 실패(모든 전화 통화중), 10:완료(콜연결-통화중), 11:완료(응답업음), 12:완료(결번), 13:완료(정보청취), 1Q:완료(성공), 1Z:완료(기타), 90:에러, 91:에러, 92:에러, 93:에러, 9Q:에러, 9Z:에러, 20:완료(알림톡), 21:완료(알림톡(Kakao)), 22:완료(알림톡(Web)), 23:완료(알림톡 > 해피톡(Kakao)), 24:완료(알림툭 > 해피톡(Web), 25:완료(SMS(Kakao)), 26:완료(SMS(Web)), 27:완료(SMS > 해피톡(Kakao)), 28:완료(SMS > 해피톡(Web))",
 *          example="01"
 *      )
 * )
 *
 * '호정보 완료 통합 코드' 값객체 클래스
 * Class Cause
 * @package App\Domains\SiteCdrPartition\Values
 */
class ResultCause extends Code
{
    /** @var string 콜연결 실패(연결지연) */
    const CODE_00 = '00';
    /** @var string 콜연결 실패(결번) */
    const CODE_01 = '01';
    /** @var string 콜연결 실패(결번) */
    const CODE_02 = '02';
    /** @var string 안내(정보청취) */
    const CODE_03 = '03';
    /** @var string 콜연결 실패(전화거절) */
    const CODE_04 = '04';
    /** @var string 콜연결 실패(전원꺼짐) */
    const CODE_05 = '05';
    /** @var string 콜연결 실패(알수없음) */
    const CODE_0Q = '0Q';
    /** @var string 콜연결 실패(모든 전화 통화중) */
    const CODE_0Z = '0Z';
    /** @var string 완료(콜연결-통화중) */
    const CODE_10 = '10';
    /** @var string 완료(응답업음) */
    const CODE_11 = '11';
    /** @var string 완료(결번) */
    const CODE_12 = '12';
    /** @var string 완료(정보청취) */
    const CODE_13 = '13';
    /** @var string 완료(성공) */
    const CODE_1Q = '1Q';
    /** @var string 완료(기타) */
    const CODE_1Z = '1Z';
    /** @var string 에러 */
    const CODE_90 = '90';
    /** @var string 에러 */
    const CODE_91 = '91';
    /** @var string 에러 */
    const CODE_92 = '92';
    /** @var string 에러 */
    const CODE_93 = '93';
    /** @var string 에러 */
    const CODE_9Q = '9Q';
    /** @var string 에러 */
    const CODE_9Z = '9Z';
    /** @var string 완료(알림톡) */
    const CODE_20 = '20';
    /** @var string 완료(알림톡(Kakao)) */
    const CODE_21 = '21';
    /** @var string 완료(알림톡(Web)) */
    const CODE_22 = '22';
    /** @var string 완료(알림톡 > 해피톡(Kakao)) */
    const CODE_23 = '23';
    /** @var string 완료(알림툭 > 해피톡(Web) */
    const CODE_24 = '24';
    /** @var string 완료(SMS(Kakao)) */
    const CODE_25 = '25';
    /** @var string 완료(SMS(Web)) */
    const CODE_26 = '26';
    /** @var string 완료(SMS > 해피톡(Kakao)) */
    const CODE_27 = '27';
    /** @var string 완료(SMS > 해피톡(Web)) */
    const CODE_28 = '28';

    /** @var string[] 유효한 코드 목록 */
    const CODES = ["00", "01", "02", "03", "04", "05", "0Q", "0Z", "10", "11", "12", "13", "1Q", "1Z", "90", "91", "92", "93", "9Q", "9Z", "20", "21", "22", "23", "24", "25", "26", "27", "28"];
    /** @var string[] 코드에 해당하는 이름 목록 */
    const NAMES = [
        '00' => '콜연결 실패(연결지연)',
        '01' => '콜연결 실패(결번)',
        '02' => '콜연결 실패(결번)',
        '03' => '안내(정보청취)',
        '04' => '콜연결 실패(전화거절)',
        '05' => '콜연결 실패(전원꺼짐)',
        '0Q' => '콜연결 실패(알수없음)',
        '0Z' => '콜연결 실패(모든 전화 통화중)',
        '10' => '완료(콜연결-통화중)',
        '11' => '완료(응답업음)',
        '12' => '완료(결번)',
        '13' => '완료(정보청취)',
        '1Q' => '완료(성공)',
        '1Z' => '완료(기타)',
        '90' => '에러',
        '91' => '에러',
        '92' => '에러',
        '93' => '에러',
        '9Q' => '에러',
        '9Z' => '에러',
        '20' => '완료(알림톡)',
        '21' => '완료(알림톡(Kakao))',
        '22' => '완료(알림톡(Web))',
        '23' => '완료(알림톡 > 해피톡(Kakao))',
        '24' => '완료(알림툭 > 해피톡(Web)',
        '25' => '완료(SMS(Kakao))',
        '26' => '완료(SMS(Web))',
        '27' => '완료(SMS > 해피톡(Kakao))',
        '28' => '완료(SMS > 해피톡(Web))',
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

    /**
     * ResultCause constructor.
     * @param Result $result
     * @param Cause $cause
     */
    public function __construct(Result $result, Cause $cause)
    {
        parent::__construct($result->getCode()[1].$cause->getCode());
    }
}