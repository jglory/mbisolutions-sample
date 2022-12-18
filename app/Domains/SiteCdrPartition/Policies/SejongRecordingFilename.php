<?php


namespace App\Domains\SiteCdrPartition\Policies;


use Illuminate\Support\Carbon;
use App\Models\Policy\Policy;

use \stdClass;
use App\Domains\SiteCdrPartition\Eloquents\SiteCdrPartition as SiteCdrPartitionEloquent;



/**
 * '세종 녹취록 파일명 변환 정책' 클래스
 * Class SejongRecordingFilename
 * @package App\Domains\SiteCdrPartition\Policies
 */
class SejongRecordingFilename extends Policy
{
    /**
     * @inheritdoc
     * @param stdClass|SiteCdrPartitionEloquent
     * @return string
     */
    public function apply($target)
    {
        if (empty($target->call_key)) {
            throw new \UnexpectedValueException('녹취록 파일명 생성에 실패했습니다.');
        }
        return (new RecordingDirectoryName())->apply($target).'/'.$target->call_key.'.mp3';
    }
}