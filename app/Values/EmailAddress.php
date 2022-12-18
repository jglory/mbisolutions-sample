<?php


namespace App\Values;


/**
 * 이메일 객체 클래스
 * Class EmailAddress
 * @package App\Values
 */
class EmailAddress implements \JsonSerializable
{
    private $id;
    private $domain;

    /**
     * EmailAddress constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
            throw new \InvalidArgumentException('정상적인 이메일 주소 형식이 아닙니다.');
        }
        list($this->id, $this->domain) = explode( '@', $email );
    }

    /**
     * '아이디'를 반환한다.
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * '도메인'을 반환한다.
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * 이메일 주소를 반환한다.
     * @return string
     */
    public function getAddress(): string
    {
        return $this->id . '@' . $this->domain;
    }

    /**
     * 문자열 변환 요청에 대해 이메일 주소를 반환한다.
     * @return string
     */
    public function __toString(): string
    {
        return $this->getAddress();
    }

    /**
     * 데이터를 json으로 변환하여 반환한다.
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->getAddress();
    }
}
