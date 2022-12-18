<?php


namespace App\Domains\SiteCdrPartition\Policies;


use App\Models\Policy\Policy;

use \stdClass;
use App\Domains\SiteCdrPartition\Eloquents\SiteCdrPartition as SiteCdrPartitionEloquent;



/**
 * '녹취록 파일 저장 폴더명 정책' 클래스
 * Class RecordingDirectory
 * @package App\Domains\SiteCdrPartition\Policies
 */
class RecordingDirectoryName extends Policy
{
    /**
     * @inheritdoc
     * @param stdClass|SiteCdrPartitionEloquent
     * @return string
     */
    public function apply($target)
    {
        if (empty($target->ars_num) || empty($target->cs_date)) {
            throw new \UnexpectedValueException('폴더명 생성에 실패했습니다.');
        }
        return '/'.$target->ars_num.'/'.substr($target->cs_date, 0, 6);
    }
}