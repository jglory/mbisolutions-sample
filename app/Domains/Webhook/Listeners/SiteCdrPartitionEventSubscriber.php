<?php

namespace App\Domains\Webhook\Listeners;



use Illuminate\Support\Facades\Notification;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Domains\SiteCdrPartition\Events\CallerCallingCallee as CallerCallingCalleeEvent;
use App\Domains\SiteCdrPartition\Events\CallerConnectedToCallee as CallerConnectedToCalleeEvent;
use App\Domains\SiteCdrPartition\Events\CallerStoppedCallingCallee as CallerStoppedCallingCalleeEvent;
use App\Domains\SiteCdrPartition\Events\Finished as FinishedEvent;
use App\Domains\SiteCdrPartition\Values\Type;


/**
 * Class SiteCdrPartitionEventSubscriber
 * @package App\Domains\Webhook\Listeners
 */
class SiteCdrPartitionEventSubscriber
{
    use CreateReceiverFromTrait;

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(CallerCallingCalleeEvent::class, self::class.'@onCallerCallingCallee');
        $events->listen(CallerConnectedToCalleeEvent::class, self::class.'@onCallerConnectedToCallee');
        $events->listen(CallerStoppedCallingCalleeEvent::class, self::class.'@onCallerStoppedCallingCallee');
        $events->listen(FinishedEvent::class, self::class.'@onFinished');
    }

    /**
     * Handle the CallerCallingCallee event.
     *
     * @param  CallerCallingCalleeEvent  $event
     * @return void
     */
    public function onCallerCallingCallee(CallerCallingCalleeEvent $event)
    {
        Notification::send(
            $this->createReceiverFrom($event->getCdr()->type==Type::INBOUND ? $event->getCallee() : $event->getCaller()),
            new \App\Notifications\SiteCdrPartition\CallerCallingCallee($event)
        );
    }

    /**
     * Handle the CallerConnectedToCallee event.
     *
     * @param  CallerConnectedToCalleeEvent  $event
     * @return void
     */
    public function onCallerConnectedToCallee(CallerConnectedToCalleeEvent $event)
    {
        Notification::send(
            $this->createReceiverFrom($event->getCdr()->type==Type::INBOUND ? $event->getCallee() : $event->getCaller()),
            new \App\Notifications\SiteCdrPartition\CallerConnectedToCallee($event)
        );
    }

    /**
     * Handle the CallerStoppedCallingCallee event.
     *
     * @param  CallerStoppedCallingCalleeEvent  $event
     * @return void
     */
    public function onCallerStoppedCallingCallee(CallerStoppedCallingCalleeEvent $event)
    {
        Notification::send(
            $this->createReceiverFrom($event->getCdr()->type==Type::INBOUND ? $event->getCallee() : $event->getCaller()),
            new \App\Notifications\SiteCdrPartition\CallerStoppedCallingCallee($event)
        );
    }

    /**
     * Handle the Finished event.
     *
     * @param  FinishedEvent  $event
     * @return void
     */
    public function onFinished(FinishedEvent $event)
    {
        if (empty($event->getCdr()->cus_id)===false) {
            Notification::send(
                $this->createReceiverFrom($event->getCdr()->type==Type::INBOUND ? $event->getCallee() : $event->getCaller()),
                new \App\Notifications\SiteCdrPartition\Finished($event)
            );
        }
    }
}
