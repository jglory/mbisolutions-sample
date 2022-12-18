<?php

namespace App\Notifications\SiteCdrPartition;


use App\Domains\SiteCdrPartition\Events\Finished as SiteCdrPartitionFinishedEvent;
use App\Modules\Broadcasting\BroadcastMessage;
use App\Notifications\Web;



/**
 * 호종료가 되었음을 의미하는 노티피케이션 클래스
 * Class Finished
 * @package App\Notifications\SiteCdrPartition
 */
class Finished extends Web
{
    /**
     * @inheritDoc
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        /** @var SiteCdrPartitionFinishedEvent $payload */
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
