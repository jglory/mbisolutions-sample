<?php


namespace App\Values;


/**
 * 콜상태값 클래스
 * Class CallStatus
 * @package App\Values
 */
class CallStatus implements \JsonSerializable
{
    /** @var array 통화상태 코드 맵 */
    const CODES = [
        '00', //'안내(정보청취)',
        '01', //'콜연결 실패(신호없음)',
        '02', //'콜연결 실패(결번)',
        '03', //'콜연결 실패',
        '0Q', //'콜연결 실패',
        '0Z', //'콜연결 실패(모든 전화 통화중)',
        '10', //'완료(콜연결-통화중)',
        '11', //'완료(응답업음)',
        '12', //'완료(결번)',
        '13', //'완료(발신자 전화끊음)',
        '1Q', //'완료(성공)',
        '1Z', //'완료(기타)',
        '90', //'에러',
        '91', //'에러',
        '92', //'에러',
        '93', //'에러',
        '9Q', //'에러',
        '9Z', //'에러'
        '20', //'완료(알림톡)',               //알림톡 연동 Y / 알림톡 발송
        '21', //'완료(알림톡(Kakao))',        //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(kakao)
        '22', //'완료(알림톡(Web))',          //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(Web)
        '23', //'완료(알림톡 > 해피톡(Kakao))', //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(kakao) 성공
        '24', //'완료(알림툭 > 해피톡(Web)',    //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(Web) 성공
        '25', //'완료(SMS(Kakao))',         //SMS 연동 Y / SMS 발송 / 해피톡 연결(kakao)
        '26', //'완료(SMS(Web))',           //SMS 연동 Y / SMS 발송 / 해피톡 연결(Web)
        '27', //'완료(SMS > 해피톡(Kakao))',  //SMS 연동 Y / SMS 발송 / 해피톡 연결(kakao) 성공
        '28', //'완료(SMS > 해피톡(Web))',    //SMS 연동 Y / SMS 발송 / 해피톡 연결(Web) (성공)
    ];

    /** @var array {통화상태 코드 => 설명 메세지} 맵 */
    const MESSAGES = [
        '00' => '안내(정보청취)',
        '01' => '콜연결 실패(신호없음)',
        '02' => '콜연결 실패(결번)',
        '03' => '콜연결 실패',
        '0Q' => '콜연결 실패',
        '0Z' => '콜연결 실패(모든 전화 통화중)',
        '10' => '완료(콜연결-통화중)',
        '11' => '완료(응답업음)',
        '12' => '완료(결번)',
        '13' => '완료(발신자 전화끊음)',
        '1Q' => '완료(성공)',
        '1Z' => '완료(기타)',
        '90' => '에러',
        '91' => '에러',
        '92' => '에러',
        '93' => '에러',
        '9Q' => '에러',
        '9Z' => '에러',
        '20' => '완료(알림톡)',               //알림톡 연동 Y / 알림톡 발송
        '21' => '완료(알림톡(Kakao))',        //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(kakao)
        '22' => '완료(알림톡(Web))',          //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(Web)
        '23' => '완료(알림톡 > 해피톡(Kakao))', //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(kakao) 성공
        '24' => '완료(알림툭 > 해피톡(Web)',    //알림톡 연동 Y / 알림톡 발송 / 해피톡연결(Web) 성공
        '25' => '완료(SMS(Kakao))',         //SMS 연동 Y / SMS 발송 / 해피톡 연결(kakao)
        '26' => '완료(SMS(Web))',           //SMS 연동 Y / SMS 발송 / 해피톡 연결(Web)
        '27' => '완료(SMS > 해피톡(Kakao))',  //SMS 연동 Y / SMS 발송 / 해피톡 연결(kakao) 성공
        '28' => '완료(SMS > 해피톡(Web))',    //SMS 연동 Y / SMS 발송 / 해피톡 연결(Web) (성공)
    ];

    /** @var string 상태 코드 */
    private $code;
    /** @var string 설명 메세지 */
    private $message;

    /**
     * CallStatus constructor.
     * @param bool $hasSentAlimtalk
     * @param string|null $receiverTelephoneNo
     * @param string|null $roomId
     * @param string $callResult
     * @param string $cause
     */
    public function __construct(bool $hasSentAlimtalk, ?string $receiverTelephoneNo, ?string $roomId, string $callResult, string $cause)
    {
        if ($hasSentAlimtalk) {
            $this->code = '2'.($roomId==null || $roomId=='' ? '0' : '1');
        } else {
            if (empty($receiverTelephoneNo)) {
                $this->code = '00';
            } else {
                switch ($callResult) {
                    case '00':
                    case '01':
                    case '99':
                        switch ($cause) {
                            case '0':
                            case '1':
                            case '2':
                            case '3':
                            case 'Q':
                            case 'Z':
                                $this->code = $callResult[1].$cause;
                                break;
                            default:
                                $this->code = '';
                                break;
                        }
                        break;
                    default:
                        $this->code = '';
                        break;
                }
            }
        }

        $this->message = ($this->code==='' ? '알수없음' : self::MESSAGES[$this->code]);
    }

    /**
     * '상태 코드'를 돌려준다.
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * 설명 메세지를 돌려준다.
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
        ];
    }
}
