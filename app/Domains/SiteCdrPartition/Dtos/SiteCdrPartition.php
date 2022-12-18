<?php

namespace App\Domains\SiteCdrPartition\Dtos;


use Carbon\Carbon;

use App\Models\Dto\Dto;

use App\Domains\SiteCdrPartition\Values\Result;
use App\Domains\SiteCdrPartition\Values\Cause;
use App\Domains\SiteCdrPartition\Values\Type;

use App\Values\PhoneNumber;



/**
 * SiteCdrPartition Dto 클래스
 * Class SiteCdrPartition
 * @package  App\Domains\SiteCdrPartition\Dtos
 *
 * @property int|null $cdr_idx  int(11)   NOT NULL COMMENT '고유키'
 * @property Carbon|null $cdr_regdt  datetime   NOT NULL COMMENT '생성 일시'
 * @property string|null $call_key  varchar(20)   COMMENT '콜키'
 * @property PhoneNumber|null $ani  varchar(20)   COMMENT '발신번호'
 * @property string|null $cus_id  varchar(20)   COMMENT '고객 ID'
 * @property PhoneNumber|null $cus_tel  varchar(20)   COMMENT '상담원 전화번호'
 * @property PhoneNumber|null $ars_num  varchar(20)   COMMENT '접속번호(대표번호)'
 * @property string|null $cs_date  varchar(8)   COMMENT '발신일(yyyymmdd)'
 * @property string|null $cs_time  varchar(6)   COMMENT '발신시점(hhmmss)'
 * @property string|null $ss_date  varchar(8)   COMMENT '수신자(상담원) 수신일(yyyymmdd)'
 * @property string|null $ss_time  varchar(6)   COMMENT '수신자(상담원) 수신시점(hhmmss)'
 * @property string|null $ce_date  varchar(8)   COMMENT '통화종료일자(yyyymmdd)'
 * @property string|null $ce_time  varchar(6)   COMMENT '통화종료시간(hhmmss)'
 * @property int|null $svc_duration  int(11)   COMMENT '통화시간(초)'
 * @property Result|null $call_result  char(2)   COMMENT '통화결과'
 * @property Cause|null $cause  char(2)   COMMENT '불완료 통화 코드'
 * @property string|null $gubun  char(1)   COMMENT '알림톡 발송 유무'
 * @property string|null $rec_yn  char(1)   COMMENT '녹취유무'
 * @property string|null $room_id  char(30)   COMMENT '해피톡 상담 룸 아이디'
 * @property string|null $recfile_name  varchar(400)   COMMENT '녹취화일 이름 - 사용안함'
 * @property string|null $memo  varchar(2000)   COMMENT '상담원메모'
 * @property int|null $etc_1  varchar(100)   COMMENT ''
 * @property string|null $etc_2  varchar(100)   COMMENT '녹취록 원본 다운로드 링크'
 * @property int|null $etc_3  varchar(100)   COMMENT '녹취파일 용량'
 * @property int|null $etc_4  varchar(100)   COMMENT '수신자(상담원) 아이디'
 * @property string|null $etc_5  varchar(100)   COMMENT ''
 * @property string|null $etc_6  varchar(100)   COMMENT ''
 * @property string|null $etc_7  varchar(100)   COMMENT ''
 * @property string|null $etc_8  varchar(100)   COMMENT ''
 * @property string|null $etc_9  varchar(100)   COMMENT '메모 정렬 (즐겨찾기)'
 * @property array|null $etc_10  varchar(100)   COMMENT '마지막 선택 시나리오 정보'
 * @property string|null $rec_result  char(3)   NOT NULL COMMENT '녹취파일 저장 결과'
 * @property Carbon|null $rec_result_time  datetime   COMMENT '녹취파일 저장 시간',
 * @property int|string|null $site_id  bigint(20) unsigned DEFAULT NULL COMMENT '사이트 아이디',
 * @property Type|null $type  char(1) NOT NULL DEFAULT 'I' COMMENT '타입. I:인바운드, O:아웃바운드',
 * @property bool $is_delete_recording  tinyint(1) NOT NULL DEFAULT '0' COMMENT '타입. 0:미삭제, 1:삭제',
 */
class SiteCdrPartition extends Dto
{
    protected $attributes = [
        'cdr_idx' => null,
        'cdr_regdt' => null,
        'call_key' => null,
        'ani' => null,
        'cus_id' => null,
        'cus_tel' => null,
        'ars_num' => null,
        'cs_date' => null,
        'cs_time' => null,
        'ss_date' => null,
        'ss_time' => null,
        'ce_date' => null,
        'ce_time' => null,
        'svc_duration' => null,
        'call_result' => null,
        'cause' => null,
        'gubun' => null,
        'rec_yn' => null,
        'room_id' => null,
        'recfile_name' => null,
        'memo' => null,
        'etc_1' => null,
        'etc_2' => null,
        'etc_3' => null,
        'etc_4' => null,
        'etc_5' => null,
        'etc_6' => null,
        'etc_7' => null,
        'etc_8' => null,
        'etc_9' => null,
        'etc_10' => null,
        'rec_result' => null,
        'rec_result_time' => null,
        'site_id' => null,
        'type' => null,
        'is_delete_recording' => false,
    ];
}
