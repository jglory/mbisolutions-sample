<?php


namespace App\Values;

/**
 * Ip 객체 클래스
 * Class IpAddress
 * @package App\Values
 */
class IpAddress implements \JsonSerializable
{
    /** @var string IP */
    private $ip;
    /** @var int IP를 변환한 값 */
    private $no;

    /**
     * IpAddress constructor.
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)==false) {
            throw new \InvalidArgumentException('정상적인 IP 주소 형식이 아닙니다.');
        }
        $this->ip = $ip;
        $this->no = ip2long($ip);
    }

    /**
     * 문자열 변환 요청에 대해 IP 주소를 반환한다.
     * @return string
     */
    public function __toString(): string
    {
        return $this->ip;
    }

    /**
     * IP를 돌려준다.
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * IP를 숫자로 변환한 결과값을 돌려준다.
     * @return int
     */
    public function getNo(): int
    {
        return $this->no;
    }

    /**
     * 데이터를 json으로 변환하여 반환한다.
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->ip;
    }

    /**
     * 사설 IP 인지 여부를 돌려준다.
     * @return bool
     */
    public function isPrivate(): bool
    {
        static $privates = [
            [167772160, 184549375], // 10.0.0.0 - 10.255.255.255
            [2886729728, 2887778303], // 172.16.0.0 - 172.31.255.255
            [3232235520, 3232301055], // 192.168.0.0 - 192.168.255.255
        ];

        foreach ($privates as $range) {
            if ($range[0]<=$this->no && $range[1]>=$this->no) {
                return true;
            }
        }
        return false;
    }

    /**
     * 루프백 IP 인지 여부를 돌려준다.
     * @return bool
     */
    public function isLoopback(): bool
    {
        return 2130706432<=$this->no && 2147483647>=$this->no; // 127.0.0.0 - 127.255.255.255
    }

    /**
     * 내부 IP 인지 여부를 돌려준다.
     * @return bool
     */
    public function isInternalIp(): bool
    {
        return 3695654115<=$this->no && 3695654116 >= $this->no; //220.71.52.227 - 220.71.52.228
    }
}
