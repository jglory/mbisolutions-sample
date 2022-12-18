<?php

namespace App\Domains\SiteCdrPartition\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Domains\CtiGuest\Dtos\CtiGuest as CtiGuestDto;

use App\Domains\Member\Dtos\Member as MemberDto;
use App\Domains\Scenario\Dtos\Scenario as SiteScenarioDto;
use App\Domains\SiteCdrPartition\Dtos\SiteCdrPartition as SiteCdrPartitionDto;
use App\Domains\SiteLinkNo\Dtos\SiteLinkNo as SiteLinkNoDto;

use App\Values\PhoneNumber;



/**
 * 발신자(고객)가 누른 번호가 도착했음을 의미하는 이벤트 클래스
 * Class CallerInputReceived
 * @package App\Domains\SiteCdrPartition\Events
 */
class CallerInputReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var SiteCdrPartitionDto 호정보 */
    private $cdr;
    /** @var CtiGuestDto 발신자 */
    private $caller;
    /** @var PhoneNumber 발신자 번호 */
    private $callerNo;
    /** @var SiteScenarioDto */
    private $scenario;

    /**
     * Create a new event instance.
     *
     * @param SiteCdrPartitionDto $cdr
     * @param CtiGuestDto $caller
     * @param PhoneNumber $callerNo
     * @param SiteScenarioDto $scenario
     * @return void
     */
    public function __construct(SiteCdrPartitionDto $cdr, CtiGuestDto $caller, PhoneNumber $callerNo, SiteScenarioDto $scenario)
    {
        $this->cdr = clone $cdr;
        $this->caller = clone $caller;
        $this->callerNo = clone $callerNo;
        $this->scenario = clone $scenario;
    }

    /**
     * '호정보'를 돌려준다.
     * @return SiteCdrPartitionDto
     */
    public function getCdr(): SiteCdrPartitionDto
    {
        return $this->cdr;
    }

    /**
     * '발신자' 정보를 돌려준다.
     * @return CtiGuestDto
     */
    public function getCaller(): CtiGuestDto
    {
        return $this->caller;
    }

    /**
     * '발신자 전화번호' 정보를 돌려준다.
     * @return PhoneNumber
     */
    public function getCallerNo(): PhoneNumber
    {
        return $this->callerNo;
    }

    /**
     * '시나리오' 정보를 돌려준다.
     * @return SiteScenarioDto
     */
    public function getScenario(): SiteScenarioDto
    {
        return $this->scenario;
    }
}