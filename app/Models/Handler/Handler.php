<?php


namespace App\Models\Handler;


/**
 * 커맨드 객체를 처리하는 객체 클래스
 * Class Handler
 * @package App\Models\Handlers
 */
abstract class Handler
{
    /**
     * 커맨드 객체를 처리한다.
     * @param $command
     * @return mixed
     */
    abstract public function process($command);
}