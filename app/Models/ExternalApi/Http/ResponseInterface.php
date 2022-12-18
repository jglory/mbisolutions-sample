<?php


namespace App\Models\ExternalApi\Http;


/**
 * Response 인터페이스
 * interface ResponseInterface
 * @package App\Models\ExternalApi\Http
 */
interface ResponseInterface
{
    /**
     * HTTP 응답 코드를 돌려준다.
     * @return int
     */
    public function getStatusCode(): int;
}
