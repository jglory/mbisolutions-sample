<?php


namespace App\Http\Requests;

/**
 * Request 베이스 클래스
 * Class Request
 * @package App\Http\Requests
 */
abstract class Request
    extends \Illuminate\Http\Request
    implements GetCommandInterface
{
}