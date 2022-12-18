<?php


namespace App\Values;



/**
 * @OA\Schema(
 *      schema="App.Values.Code",
 *      required={"code"},
 *      @OA\Property(property="code", type="array", @OA\Items(anyOf={@OA\Schema(type="string"), @OA\Schema(type="int")}), description="코드", example=""),
 * )
 *
 * Code 클래스
 * Class Code
 * @package App\Values
 */
abstract class Code extends Value implements CodeInterface
{
    /**
     * 코드 목록을 돌려준다.
     * @return array
     */
    abstract public static function getCodes(): array;

    /** @var mixed 설정 코드 */
    protected $code;

    /**
     * 입력 코드값이 설정 가능한 코드값인지 여부를 돌려준다.
     * @param $code
     * @return bool
     */
    public static function isValidCode($code): bool
    {
        return in_array($code, static::getCodes());
    }

    /**
     * Code constructor.
     * @param $code
     */
    public function __construct($code)
    {
        if (static::isValidCode($code)==false) {
            throw new \InvalidArgumentException();
        }
        $this->code = $code;
    }

    /**
     * '코드' 값을 반환한다.
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @inheritDoc
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->code;
    }

    /**
     * 설정 코드값을 문자열로 변환하여 돌려준다.
     * @return string
     */
    public function __toString(): string
    {
        return $this->code;
    }
}
