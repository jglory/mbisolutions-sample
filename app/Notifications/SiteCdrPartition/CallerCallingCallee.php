<?php

namespace App\Notifications\SiteCdrPartition;


use App\Domains\SiteCdrPartition\Events\CallerCallingCallee as SiteCdrPartitionCallerCallingCalleeEvent;
use App\Modules\Broadcasting\BroadcastMessage;
use App\Notifications\Web;



/**
 * 발신자(고객)가 수신자(상담원)과 전화연결을 시도 중임을 알리는 노티피케이션 클래스
 * Class CallerCallingCallee
 * @package App\Notifications\SiteCdrPartition
 */
class CallerCallingCallee extends Web
{
    /**
     * @inheritDoc
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        /** @var SiteCdrPartitionCallerCallingCalleeEvent $payload */
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
