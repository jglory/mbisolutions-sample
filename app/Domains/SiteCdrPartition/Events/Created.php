<?php


namespace App\Domains\SiteCdrPartition\Events;


use App\Values\PhoneNumber;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Domains\CtiGuest\Dtos\CtiGuest as CtiGuestDto;
use App\Domains\Member\Dtos\Member as MemberDto;
use App\Domains\SiteCdrPartition\Dtos\SiteCdrPartition as SiteCdrPartitionDto;
use App\Domains\SiteLinkNo\Dtos\SiteLinkNo as SiteLinkNoDto;




/**
 * '호정보 시작됨' 이벤트 클래스
 * Class Created
 * @package App\Domains\SiteCdrPartition\Events
 */
class Created
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var SiteCdrPartitionDto 호정보 */
    private $cdr;
    /** @var MemberDto|CtiGuestDto 발신자 */
    private $caller;
    /** @var SiteLinkNoDto|PhoneNumber 발신자 번호 */
    private $callerNo;
    /** @var MemberDto|CtiGuestDto|null 수신자 */
    private $callee;
    /** @var SiteLinkNoDto|PhoneNumber|null 수신자 번호 */
    private $calleeNo;

    /**
     * Create a new event instance.
     *
     * @param SiteCdrPartitionDto $cdr
     * @param MemberDto|CtiGuestDto $caller
     * @param SiteLinkNoDto|PhoneNumber $callerNo
     * @param MemberDto|CtiGuestDto|null $callee
     * @param SiteLinkNoDto|PhoneNumber|null $calleeNo
     * @return void
     */
    public function __construct(SiteCdrPartitionDto $cdr, $caller, $callerNo, $callee, $calleeNo)
    {
        $this->cdr = $cdr;
        $this->caller = $caller;
        $this->callerNo = $callerNo;
        $this->callee = $callee;
        $this->calleeNo = $calleeNo;
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
     * @return MemberDto|CtiGuestDto
     */
    public function getCaller()
    {
        return $this->caller;
    }

    /**
     * '발신자 전화번호' 정보를 돌려준다.
     * @return SiteLinkNoDto|PhoneNumber
     */
    public function getCallerNo()
    {
        return $this->callerNo;
    }

    /**
     * '수신자' 정보를 돌려준다.
     * @return MemberDto|CtiGuestDto|null
     */
    public function getCallee()
    {
        return $this->callee;
    }

    /**
     * '수신자 전화번호' 정보를 돌려준다.
     * @return SiteLinkNoDto|PhoneNumber|null
     */
    public function getCalleeNo()
    {
        return $this->calleeNo;
    }
}
