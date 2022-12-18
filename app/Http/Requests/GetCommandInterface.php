<?php


namespace App\Http\Requests;

/**
 * GetCommand 인터페이스
 * Interface GetCommandInterface
 * @package App\Http\Requests
 */
interface GetCommandInterface
{
    /**
     * Command 를 돌려준다.
     * @return mixed
     */
    public function getCommand();
}