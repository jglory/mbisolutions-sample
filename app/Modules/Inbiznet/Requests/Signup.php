<?php


namespace App\Modules\Inbiznet\Requests;

use App\Models\ExternalApi\Http\Request;
use Illuminate\Support\Carbon;

/**
 * 서비스 가입 알림 Request 클래스
 * Class Signup
 * @package App\Modules\Inbiznet\Requests\Signup
 */
class Signup extends Request
{
    /** @var string 요청번호 */
    private $id;

    /** @var Carbon 요청일자 */
    private $at;

    /** @var int 사이트 아이디 */
    private $siteId;

    /** @var string 사이트명 */
    private $name;

    /** @var string 대표번호 */
    private $arsNo;

    /** @var string 링크번호 */
    private $intermediateNo;

    /** @var string 070매칭번호 */
    private $ivrNumber;

    /**
     * Signup constructor.
     *
     * @param string $id
     * @param Carbon $at
     * @param int    $siteId
     * @param string $name
     * @param string $arsNo
     * @param string $intermediateNo
     * @param string $ivrNumber
     */
    public function __construct(string $id, Carbon $at, int $siteId, string $name, string $arsNo, string $intermediateNo, string $ivrNumber)
    {
        $this->id = $id;
        $this->at = $at;
        $this->siteId = $siteId;
        $this->name = $name;
        $this->arsNo = $arsNo;
        $this->intermediateNo = $intermediateNo;
        $this->ivrNumber = $ivrNumber;
    }

    /**
     * '요청번호'를 반환한다.
     * @return string
     */
    public function getCmd(): string
    {
        return 'Cmd_2110';
    }

    /**
     * '요청번호'를 반환한다.
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * '요청일시'를 반환한다.
     * @return Carbon
     */
    public function getAt(): Carbon
    {
        return $this->at;
    }

    /**
     * '사이트 아이디'를 반환한다.
     * @return string
     */
    public function getSiteId(): string
    {
        return $this->siteId;
    }

    /**
     * '사이트명'를 반환한다.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * '대표번호'를 반환한다.
     * @return string
     */
    public function getArsNo(): string
    {
        return $this->arsNo;
    }

    /**
     * '링크번호'를 반환한다.
     * @return string
     */
    public function getIntermediateNo(): string
    {
        return $this->intermediateNo;
    }

    /**
     * '070매칭번호'를 반환한다.
     * @return string
     */
    public function getIvrNumber(): string
    {
        return $this->ivrNumber;
    }
}