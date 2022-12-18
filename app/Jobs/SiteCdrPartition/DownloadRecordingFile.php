<?php

namespace App\Jobs\SiteCdrPartition;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Commands\SiteCdrPartition\DownloadRecordingFile as SiteCdrPartitionDownloadRecordingFileCommand;
use App\Handlers\SiteCdrPartition\DownloadRecordingFile as SiteCdrPartitionDownloadRecordingFileHandler;



/**
 * '호정보 관련 녹취록 다운로드' Job 클래스
 * Class DownloadRecordingFile
 * @package App\Jobs\SiteCdrPartition
 */
class DownloadRecordingFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var int 사이트 아이디 */
    protected $siteId;
    /** @var \stdClass 호정보 */
    protected $cdrRd;

    /**
     * Create a new job instance.
     *
     * @param int $siteId
     * @param \stdClass $cdrRd
     */
    public function __construct(int $siteId, \stdClass $cdrRd)
    {
        $this->siteId = $siteId;
        $this->cdrRd = $cdrRd;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new SiteCdrPartitionDownloadRecordingFileHandler())->process(new SiteCdrPartitionDownloadRecordingFileCommand($this->siteId, $this->cdrRd->cdr_idx));
    }
}
