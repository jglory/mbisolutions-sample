<?php


namespace App\Models\Aggregate;


use App\Models\Util\FriendClassTrait;


/**
 * 애그리거트 베이스 클래스
 * class Aggregate
 * @package App\Models\Aggregates
 */
abstract class Aggregate
{
    use FriendClassTrait;
}
