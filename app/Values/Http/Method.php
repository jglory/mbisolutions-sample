<?php


namespace App\Values\Http;


use App\Values\Code;



/**
 * HTTP method 클래스
 * Class Method
 * @package App\Values\Http
 */
class Method extends Code
{
    /** @var string GET */
    const GET = 'GET';
    /** @var string HEAD */
    const HEAD = 'HEAD';
    /** @var string POST */
    const POST = 'POST';
    /** @var string PUT */
    const PUT = 'PUT';
    /** @var string PATCH */
    const PATCH = 'PATCH';
    /** @var string DELETE */
    const DELETE = 'DELETE';
    /** @var string OPTIONS */
    const OPTIONS = 'OPTIONS';

    /** @var string[] 유효한 코드 목록 */
    const CODES = [self::GET, self::HEAD, self::POST, self::PUT, self::PATCH, self::DELETE, self::OPTIONS];

    /**
     * @inheritdoc
     * @return array
     */
    public static function getCodes(): array
    {
        return static::CODES;
    }
}