<?php

namespace App\Notifications\SiteCdrPartition;


use App\Domains\SiteCdrPartition\Events\CallerStoppedCallingCallee as SiteCdrPartitionCallerStoppedCallingCalleeEvent;
use App\Modules\Broadcasting\BroadcastMessage;
use App\Notifications\Web;



/**
 * 발신자(고객)가 수신자(상담원)과 전화연결을 중지했음을 알리는 노티피케이션 클래스
 * Class CallerStoppedCallingCallee
 * @package App\Notifications\SiteCdrPartition
 */
class CallerStoppedCallingCallee extends Web
{
    /**
     * @inheritDoc
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        /** @var SiteCdrPartitionCallerStoppedCallingCalleeEvent $payload */
        $payload = $this->payload;

        return new BroadcastMessage([
            'cdr' => $payload->getCdr(),
            'caller' => $payload->getCaller(),
            'callerNo' => $payload->getCallerNo(),
            'callee' => $payload->getCallee(),
            'calleeNo' => $payload->getCalleeNo(),
        ]);
    }
}
