<?php

namespace App\Notifications\SiteCdrPartition;


use App\Domains\SiteCdrPartition\Events\CallerConnectedToCallee as SiteCdrPartitionCallerConnectedToCalleeEvent;
use App\Modules\Broadcasting\BroadcastMessage;
use App\Notifications\Web;



/**
 * 발신자(고객)가 수신자(상담원)와 연결되었음을 의미하는 노티피케이션 클래스
 * Class CallerConnectedToCallee
 * @package App\Notifications\SiteCdrPartition
 */
class CallerConnectedToCallee extends Web
{
    /**
     * @inheritDoc
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        /** @var SiteCdrPartitionCallerConnectedToCalleeEvent $payload */
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
