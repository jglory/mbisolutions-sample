<?php


namespace App\Models\Util;


/**
 * friend 클래스 적용을 위한 트레이트
 * Trait FriendClassTrait
 * @package App\Models\Util
 */
trait FriendClassTrait
{
    /** @var array friend 클래스 목록 */
    protected $friendClasses = [];

    /**
     * 호출한 클래스가 friend 클래스인지 체크한다.
     * @throws \BadMethodCallException
     */
    protected function checkCalledClassIsFriend()
    {
        $caller = '';
        $backtraces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $callee = $backtraces[1]['class'];
        $count = count($backtraces);
        for($i=2; $i<$count; ++$i) {
            $backtrace = &$backtraces[$i];
            if ($backtrace['class']!==$callee) {
                $caller = $backtrace['class'];
                break;
            }
        }

        if (in_array($caller, $this->friendClasses)===false) {
            throw new \BadMethodCallException($caller.'는 접근 허용된 클래스가 아닙니다.');
        }
    }
}