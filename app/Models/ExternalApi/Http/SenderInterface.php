<?php


namespace App\Models\ExternalApi\Http;



/**
 * 요청 전송 처리자 인터페이스
 * Interface SenderInterface
 * @package App\Models0\ExternalApi\Http
 */
interface SenderInterface
{
    /**
     * 요청을 전송하고 응답을 돌려준다.
     * @param Request $request
     * @return mixed
     */
    public function send(Request $request): Response;
}
