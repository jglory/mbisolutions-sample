<?php


namespace App\Models\ExternalApi\Http;


/**
 * Request 인터페이스
 * interface RequestInterface
 * @package App\Models\ExternalApi\Http
 */
interface RequestInterface
{
    /**
     * 요청을 전송하고 반환된 응답을 돌려준다.
     * @return ResponseInterface
     */
    public function send(): ResponseInterface;
}
