<?php


namespace App\Models\ExternalApi\Http;



/**
 * 클라이언트 베이스 클래스
 * Class Client
 * @package App\Models\ExternalApi\Http
 */
abstract class Client implements SenderInterface
{
    /** @var SenderInterface[]  */
    protected $senders = [];

    public function send(Request $request): Response
    {
        $class = get_class($request);
        if (isset($this->senders[$class])==false) {
            throw new \UnexpectedValueException($class.' 요청에 해당하는 전송기를 찾을 수 없습니다.');
        }

        return $this->senders[$class]->send($request);
    }
}