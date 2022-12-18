<?php


namespace App\Values;

/**
 * 전화번호 값객체 클래스
 * Class PhoneNumber
 * @package App\Values
 */
class PhoneNumber implements \JsonSerializable
{
    /** @var string 전화번호 */
    private $number;
    /** @var bool 모바일 번호 여부 */
    private $isMobile;

    /**
     * 전화번호 생성자
     *
     * @param string $number
     * @throws \UnexpectedValueException 입력값이 정해진 형식에 맞지 않으면
     */
    public function __construct(string $number)
    {
        $replaced = preg_replace("/\D+/", '', $number);
        if (strlen($replaced)<5) {
            throw new \UnexpectedValueException('비정상적인 입력. 입력된 '.$number.'는 전화번호 형식에 맞지 않습니다.');
        }
        if ($replaced[0]==='0') {
            $this->isMobile = in_array(substr($replaced, 0, 3), ['010', '011', '016', '017', '018', '019']);
        } elseif ($replaced[0]==='8' && $replaced[1]==='2') {
            $this->isMobile = in_array(substr($replaced, 0, 3), ['8210', '8211', '8216', '8217', '8218', '8219']);
        } else {
            $this->isMobile = false;
        }
        $this->number = $replaced;
    }

    /**
     * 전화번호를 돌려준다.
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * 모바일 번호인지 여부를 돌려준다.
     * @return bool
     */
    public function isMobile(): bool
    {
        return $this->isMobile;
    }

    /**
     * 문자열로 출력이 가능하도록 한다.
     * @return string
     */
    public function __toString(): string
    {
        return $this->getNumber();
    }

    /**
     * @inheritDoc
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->getNumber();
    }
}
