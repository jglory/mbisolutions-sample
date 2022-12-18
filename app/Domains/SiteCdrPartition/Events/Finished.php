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
 * '호정보 완료되었음' 이벤트 클래스
 * Class Finished
 * @package App\Domains\SiteCdrPartition\Events
 */
class Finished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var SiteCdrPartitionDto 호정보 */
    private $cdr;
    /** @var MemberDto|CtiGuestDto 발신자 */
    private $caller;
    /** @var SiteLinkNoDto|PhoneNumber 발신자 번호 */
    private $callerNo;
    /** @var MemberDto|CtiGuestDto 수신자 */
    private $callee;
    /** @var SiteLinkNoDto|PhoneNumber 수신자 번호 */
    private $calleeNo;

    /**
     * Create a new event instance.
     *
     * @param SiteCdrPartitionDto $cdr
     * @param MemberDto|CtiGuestDto $caller
     * @param SiteLinkNoDto|PhoneNumber|null $callerNo
     * @param MemberDto|CtiGuestDto|null $callee
     * @param SiteLinkNoDto|PhoneNumber $calleeNo
     * @return void
     */
    public function __construct(SiteCdrPartitionDto $cdr, $caller, $callerNo, $callee, $calleeNo)
    {
        $this->cdr = clone $cdr;
        $this->caller = clone $caller;
        $this->callerNo = clone $callerNo;
        $this->callee = is_null($callee) ? null : clone $callee;
        $this->calleeNo = is_null($calleeNo) ? null : clone $calleeNo;
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
     * @return MemberDto|CtiGuestDto
     */
    public function getCallee()
    {
        return $this->callee;
    }

    /**
     * '수신자 전화번호' 정보를 돌려준다.
     * @return SiteLinkNoDto|PhoneNumber
     */
    public function getCalleeNo()
    {
        return $this->calleeNo;
    }
}
