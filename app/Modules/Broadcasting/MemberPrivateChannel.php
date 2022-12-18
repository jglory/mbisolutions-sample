<?php


namespace App\Modules\Broadcasting;

use Illuminate\Broadcasting\PrivateChannel;



/**
 * 멤버 프라이빗 채널 클래스
 * Class MemberPrivateChannel
 * @package App\Modules\Broadcasting
 */
class MemberPrivateChannel extends PrivateChannel
{
    /** @var int 사이트 아이디 */
    private $siteId;
    /** @var int 멤버 아이디 */
    private $memberId;

    /**
     * MemberPrivateChannel constructor.
     * @param int $siteId
     * @param int $memberId
     */
    public function __construct(int $siteId, int $memberId)
    {
        $this->siteId = $siteId;
        $this->memberId = $memberId;

        parent::__construct('web-'.$this->siteId.'-'.$this->memberId);
    }

    /**
     * '채널명'을 돌려준다.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * '사이트 아이디'를 돌려준다.
     * @return int
     */
    public function getSiteId(): int
    {
        return $this->siteId;
    }

    /**
     * '멤버 아이디'를 돌려준다.
     * @return int
     */
    public function getMemberId(): int
    {
        return $this->memberId;
    }
}