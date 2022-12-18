<?php


namespace App\Modules\Inbiznet\Responses;

use App\Models\ExternalApi\Http\Response;

/**
 * 서비스 가입 알림 Responses 클래스
 * Class Signup
 * @package App\Modules\Inbiznet\Responses\Signup
 */
class Signup extends Response
{
    /** @var string 결과메세지 */
    private $message;

    /** @var string 결과코드 */
    private $code;

    /** @var string 전문고유번호 */
    private $cmd;

    /** @var string 요청번호 */
    private $id;

    /** @var string 응답일시 */
    private $at;

    /**
     * Signup constructor.
     *
     * @param string $message
     * @param string $code
     * @param string $cmd
     * @param string $id
     * @param string $at
     */
    public function __construct(string $message, string $code, string $cmd, string $id, string $at)
    {
        $this->message = $message;
        $this->code = $code;
        $this->cmd = $cmd;
        $this->id = $id;
        $this->at = $at;
    }

    /**
     * '결과메세지'를 반환한다.
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * '결과코드'를 반환한다.
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * '요청번호'를 반환한다.
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * '전문고유번호'를 반환한다.
     * @return string
     */
    public function getCmd(): string
    {
        return $this->cmd;
    }

    /**
     * '응답일시'를 반환한다.
     * @return string
     */
    public function getAt(): string
    {
        return $this->at;
    }
}