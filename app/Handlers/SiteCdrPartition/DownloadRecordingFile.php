<?php


namespace App\Handlers\SiteCdrPartition;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Carbon;

use App\Models\Handler\Handler;

use App\Commands\SiteCdrPartition\DownloadRecordingFile as DownloadRecordingFileCommand;
use App\Domains\SiteCdrPartition\Policies\RecordingFilename as RecordingFilenamePolicy;
use App\Domains\SiteCdrPartition\Eloquents\SiteCdrPartition as SiteCdrPartitionEloquent;

use App\Domains\SiteConfig\Eloquents\SiteConfig as SiteConfigEloquent;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;



/**
 * '호관련 녹취록 다운로드' Handler 클래스
 * Class DownloadRecordingFile
 * @package App\Handlers\SiteCdrPartition
 */
class DownloadRecordingFile extends Handler
{
    /**
     * @inheritdoc
     * @param DownloadRecordingFileCommand $command
     * @return mixed|void
     * @throws \Throwable
     */
    public function process($command)
    {
        /** @var SiteConfigEloquent $siteConfig */
        $siteConfig = SiteConfigEloquent::find($command->getSiteId());
        if (is_null($siteConfig)) {
            throw new \UnexpectedValueException($command->getSiteId().' 사이트를 찾을 수 없습니다.', 400);
        }
        /** @var SiteCdrPartitionEloquent $cdr */
        $cdr = SiteCdrPartitionEloquent::find($command->getCdrId());
        if (is_null($cdr)) {
            throw new \UnexpectedValueException($command->getCdrId().' 호정보를 찾을 수 없습니다.', 400);
        }

        $filename = $cdr->downloadRecordingFile();
        if (is_null($filename)) {
            throw new \UnexpectedValueException('파일이 존재하지 않습니다.');
        }
        $cdr->save();

        return [
            'path' => $filename,
        ];
    }
}