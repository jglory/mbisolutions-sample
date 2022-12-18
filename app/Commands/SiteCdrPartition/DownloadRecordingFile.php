<?php


namespace App\Commands\SiteCdrPartition;


use App\Models\Command\Command;



/**
 * '호관련 녹취록 파일 다운로드' command 클래스
 * Class DownloadRecordingFile
 * @package App\Commands\SiteCdrPartition
 */
class DownloadRecordingFile extends Command
{
    /** @var int 사이트 아이디 */
    private $siteId;
    /** @var int 호정보 아이디 */
    private $cdrId;

    /**
     * DownloadRecordingFile constructor.
     * @param int $siteId
     * @param int $cdrId
     */
    public function __construct(int $siteId, int $cdrId)
    {
        $this->siteId = $siteId;
        $this->cdrId = $cdrId;
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
     * '호정보 아이디'를 돌려준다.
     * @return int
     */
    public function getCdrId(): int
    {
        return $this->cdrId;
    }

    /**
     * @inheritdoc
     * @return mixed|void
     */
    public function jsonSerialize()
    {
        return [
            'siteId' => $this->siteId,
            'cdrId' => $this->cdrId,
        ];
    }
}