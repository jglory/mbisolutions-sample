<?php

namespace App\Domains\SiteCdrPartition\Eloquents;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

use \Exception;
use \UnexpectedValueException;

use App\Models\Eloquent\Model;

use App\Values\PhoneNumber;

use App\Domains\Scenario\Values\Type as SiteScenarioType;
use App\Domains\Scenario\Values\Action as SiteScenarioAction;
use App\Domains\Scenario\Values\Dtmf as SiteScenarioDtmf;

use App\Domains\SiteCdrPartition\Policies\RecordingFilename as InbiznetRecordingFilenamePolicy;
use App\Domains\SiteCdrPartition\Policies\RecordingDirectoryName as RecordingDirectoryNamePolicy;
use App\Domains\SiteCdrPartition\Values\Result;
use App\Domains\SiteCdrPartition\Values\Cause;
use App\Domains\SiteCdrPartition\Values\Type;



/**
 * t_cdr_partition 테이블 엘로퀀트 클래스
 * Class SiteCdrPartition
 * @package  App\Domains\SiteCdrPartition\Eloquents
 *
 * @property int $cdr_idx  int(11)   NOT NULL COMMENT '고유키'
 * @property Carbon $cdr_regdt  datetime   NOT NULL COMMENT '생성 일시'
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
 * @property string|null $etc_1  varchar(100)   COMMENT ''
 * @property string|null $etc_2  varchar(100)   COMMENT '녹취록 원본 다운로드 링크'
 * @property string|null $etc_3  varchar(100)   COMMENT '녹취파일 용량'
 * @property string|null $etc_4  varchar(100)   COMMENT ''
 * @property string|null $etc_5  varchar(100)   COMMENT ''
 * @property string|null $etc_6  varchar(100)   COMMENT ''
 * @property string|null $etc_7  varchar(100)   COMMENT ''
 * @property string|null $etc_8  varchar(100)   COMMENT ''
 * @property string|null $etc_9  varchar(100)   COMMENT '메모 정렬 (즐겨찾기)'
 * @property array|null $etc_10  varchar(100)   COMMENT '마지막 선택 시나리오 정보'
 * @property string $rec_result  char(3)   NOT NULL COMMENT '녹취파일 저장 결과'
 * @property Carbon|null $rec_result_time  datetime   COMMENT '녹취파일 저장 시간'
 * @property int|null $site_id  bigint(20) unsigned DEFAULT NULL COMMENT '사이트 아이디',
 * @property Type|null $type  char(1) NOT NULL DEFAULT 'I' COMMENT '타입. I:인바운드, O:아웃바운드',
 * @property bool $is_delete_recording tinyint(1) NOT NULL DEFAULT '0' COMMENT '삭제유무',
 */
class SiteCdrPartition extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cdr_idx';

    /**
     * The attributes that are mass assignable.
     *
     * @var  array
     */
    protected $fillable = [];

    /**
     * The table associated with the model.
     *
     * @var  string
     */
    protected $table = 't_cdr_partition';

    /**
     * The model's default values for attributes.
     *
     * @var  array
     */
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
        'rec_result' => '000',
        'rec_result_time' => null,
        'site_id' => null,
        'type' => null,
        'is_delete_recording' => false,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var  array
     */
    protected $dates = [
        'cdr_regdt', 
        'rec_result_time'
    ];

    /**
     * 암호화 필드 리스트
     */
    public $encrypteds = [
        'ani',
        'cus_tel',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->encrypter = Crypt::encrypter('SiteCdrPartition');
    }

    /**
     * '고유키'를 돌려준다.
     * @param int $val
     * @return int
     */
    public function getCdrIdxAttribute(int $val): int
    {
        return $val;
    }

    /**
     * '고유키'를 설정한다.
     * @param int $val
     * @return $this
     */
    public function setCdrIdxAttribute(int $val)
    {
        $this->attributes['cdr_idx'] = $val;
        return $this;
    }

    /**
     * '콜키'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getCallKeyAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '콜키'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setCallKeyAttribute(?string $val)
    {
        $this->attributes['call_key'] = $val;
        return $this;
    }

    /**
     * '발신번호'를 돌려준다.
     * @param string|null $val
     * @return PhoneNumber|null
     */
    public function getAniAttribute(?string $val): ?PhoneNumber
    {
        return empty($val) ? null : new PhoneNumber($val);
    }

    /**
     * '발신번호'를 설정한다.
     * @param PhoneNumber|null $val
     * @return $this
     */
    public function setAniAttribute(?PhoneNumber $val)
    {
        $this->attributes['ani'] = is_null($val) ? null : (string)$val;
        return $this;
    }

    /**
     * '고객 ID'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getCusIdAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '고객 ID'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setCusIdAttribute(?string $val)
    {
        $this->attributes['cus_id'] = $val;
        return $this;
    }

    /**
     * '상담원 전화번호'를 돌려준다.
     * @param string|null $val
     * @return PhoneNumber|null
     */
    public function getCusTelAttribute(?string $val): ?PhoneNumber
    {
        return empty($val) ? null : new PhoneNumber($val);
    }

    /**
     * '상담원 전화번호'를 설정한다.
     * @param PhoneNumber|null $val
     * @return $this
     */
    public function setCusTelAttribute($val)
    {
        $this->attributes['cus_tel'] = empty($val) ? null : new PhoneNumber($val);
        return $this;
    }

    /**
     * '접속번호(대표번호)'를 돌려준다.
     * @param string|null $val
     * @return PhoneNumber|null
     */
    public function getArsNumAttribute(?string $val): ?PhoneNumber
    {
        return empty($val) ? null : new PhoneNumber($val);
    }

    /**
     * '접속번호(대표번호)'를 설정한다.
     * @param PhoneNumber|null $val
     * @return $this
     */
    public function setArsNumAttribute(?PhoneNumber $val)
    {
        $this->attributes['ars_num'] = is_null($val) ? null : (string)$val;
        return $this;
    }

    /**
     * '발신일(yyyymmdd)'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getCsDateAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '발신일(yyyymmdd)'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setCsDateAttribute(?string $val)
    {
        $this->attributes['cs_date'] = $val;
        return $this;
    }

    /**
     * '발신시점(hhmmss)'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getCsTimeAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '발신시점(hhmmss)'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setCsTimeAttribute(?string $val)
    {
        $this->attributes['cs_time'] = $val;
        return $this;
    }

    /**
     * '수신자(상담원) 수신일(yyyymmdd)'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getSsDateAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '수신자(상담원) 수신일(yyyymmdd)'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setSsDateAttribute(?string $val)
    {
        $this->attributes['ss_date'] = $val;
        return $this;
    }

    /**
     * '수신자(상담원) 수신시점(hhmmss)'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getSsTimeAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '수신자(상담원) 수신시점(hhmmss)'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setSsTimeAttribute(?string $val)
    {
        $this->attributes['ss_time'] = $val;
        return $this;
    }

    /**
     * '통화종료일자(yyyymmdd)'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getCeDateAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '통화종료일자(yyyymmdd)'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setCeDateAttribute(?string $val)
    {
        $this->attributes['ce_date'] = $val;
        return $this;
    }

    /**
     * '통화종료시간(hhmmss)'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getCeTimeAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '통화종료시간(hhmmss)'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setCeTimeAttribute(?string $val)
    {
        $this->attributes['ce_time'] = $val;
        return $this;
    }

    /**
     * '통화시간(초)'를 돌려준다.
     * @param int|null $val
     * @return int|null
     */
    public function getSvcDurationAttribute(?int $val): ?int
    {
        return $val;
    }

    /**
     * '통화시간(초)'를 설정한다.
     * @param int|null $val
     * @return $this
     */
    public function setSvcDurationAttribute(?int $val)
    {
        $this->attributes['svc_duration'] = $val;
        return $this;
    }

    /**
     * '통화결과'를 돌려준다.
     * @param string|null $val
     * @return Result|null
     */
    public function getCallResultAttribute(?string $val): ?Result
    {
        return empty($val) ? null : new Result($val);
    }

    /**
     * '통화결과'를 설정한다.
     * @param Result|null $val
     * @return $this
     */
    public function setCallResultAttribute(?Result $val)
    {
        $this->attributes['call_result'] = is_null($val) ? null : (string)$val;
        return $this;
    }

    /**
     * '불완료 통화 코드'를 돌려준다.
     * @param string|null $val
     * @return Cause|null
     */
    public function getCauseAttribute(?string $val): ?Cause
    {
        return is_null($val) || $val=='' ? null : new Cause($val);
    }

    /**
     * '불완료 통화 코드'를 설정한다.
     * @param Cause|null $val
     * @return $this
     */
    public function setCauseAttribute(?Cause $val)
    {
        $this->attributes['cause'] = is_null($val) ? null : (string)$val;
        return $this;
    }

    /**
     * '알림톡 발송 유무'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getGubunAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '알림톡 발송 유무'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setGubunAttribute(?string $val)
    {
        $this->attributes['gubun'] = $val;
        return $this;
    }

    /**
     * '녹취유무'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getRecYnAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '녹취유무'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setRecYnAttribute(?string $val)
    {
        $this->attributes['rec_yn'] = $val;
        return $this;
    }

    /**
     * '해피톡 상담 룸 아이디'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getRoomIdAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '해피톡 상담 룸 아이디'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setRoomIdAttribute(?string $val)
    {
        $this->attributes['room_id'] = $val;
        return $this;
    }

    /**
     * '녹취화일 이름 - 사용안함'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getRecfileNameAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '녹취화일 이름 - 사용안함'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setRecfileNameAttribute(?string $val)
    {
        $this->attributes['recfile_name'] = $val;
        return $this;
    }

    /**
     * '상담원메모'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getMemoAttribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '상담원메모'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setMemoAttribute(?string $val)
    {
        $this->attributes['memo'] = $val;
        return $this;
    }

    /**
     * '사이트 아이디'를 돌려준다.
     * @param int|null $val
     * @return int|null
     */
    public function getEtc1Attribute(?int $val): ?int
    {
        return $val;
    }

    /**
     * '사이트 아이디'를 설정한다.
     * @param int|null $val
     * @return $this
     */
    public function setEtc1Attribute(?int $val)
    {
        $this->attributes['etc_1'] = $val;
        return $this;
    }

    /**
     * '녹취록 원본 다운로드 링크'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getEtc2Attribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '녹취록 원본 다운로드 링크'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setEtc2Attribute(?string $val)
    {
        $this->attributes['etc_2'] = $val;
        return $this;
    }

    /**
     * '녹취파일 용량'를 돌려준다.
     * @param int|null $val
     * @return int|null
     */
    public function getEtc3Attribute(?int $val): ?int
    {
        return $val;
    }

    /**
     * '녹취파일 용량'를 설정한다.
     * @param int|null $val
     * @return $this
     */
    public function setEtc3Attribute(?int $val)
    {
        $this->attributes['etc_3'] = $val;
        return $this;
    }

    /**
     * '수신자(상담원) 아이디'를 돌려준다.
     * @param int|null $val
     * @return int|null
     */
    public function getEtc4Attribute(?int $val): ?int
    {
        return $val;
    }

    /**
     * '수신자(상담원) 아이디'를 설정한다.
     * @param int|null $val
     * @return $this
     */
    public function setEtc4Attribute(?int $val)
    {
        $this->attributes['etc_4'] = $val;
        return $this;
    }

    /**
     * 'etc_5'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getEtc5Attribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * 'etc_5'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setEtc5Attribute(?string $val)
    {
        $this->attributes['etc_5'] = $val;
        return $this;
    }

    /**
     * 'etc_6'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getEtc6Attribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * 'etc_6'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setEtc6Attribute(?string $val)
    {
        $this->attributes['etc_6'] = $val;
        return $this;
    }

    /**
     * 'etc_7'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getEtc7Attribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * 'etc_7'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setEtc7Attribute(?string $val)
    {
        $this->attributes['etc_7'] = $val;
        return $this;
    }

    /**
     * 'etc_8'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getEtc8Attribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * 'etc_8'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setEtc8Attribute(?string $val)
    {
        $this->attributes['etc_8'] = $val;
        return $this;
    }

    /**
     * '메모 정렬 (즐겨찾기)'를 돌려준다.
     * @param string|null $val
     * @return string|null
     */
    public function getEtc9Attribute(?string $val): ?string
    {
        return $val;
    }

    /**
     * '메모 정렬 (즐겨찾기)'를 설정한다.
     * @param string|null $val
     * @return $this
     */
    public function setEtc9Attribute(?string $val)
    {
        $this->attributes['etc_9'] = $val;
        return $this;
    }

    /**
     * '마지막 선택 시나리오 정보'를 돌려준다.
     * @param string|null $val
     * @return array|null
     */
    public function getEtc10Attribute(?string $val): ?array
    {
        return empty($val) ? null : json_decode($val, true);
    }

    /**
     * '마지막 선택 시나리오 정보'를 설정한다.
     * @param array|null $val
     * @return $this
     */
    public function setEtc10Attribute($val)
    {
        $this->attributes['etc_10'] = empty($val) ? null : json_encode($val, JSON_UNESCAPED_UNICODE);
        return $this;
    }

    /**
     * '녹취파일 저장 결과'를 돌려준다.
     * @param string $val
     * @return string
     */
    public function getRecResultAttribute(string $val): string
    {
        return $val;
    }

    /**
     * '녹취파일 저장 결과'를 설정한다.
     * @param string $val
     * @return $this
     */
    public function setRecResultAttribute(string $val)
    {
        $this->attributes['rec_result'] = $val;
        return $this;
    }

    /**
     * '사이트 아이디'를 돌려준다.
     * @param int|null $val
     * @return int|null
     */
    public function getSiteIdAttribute(?int $val): ?int
    {
        return $val;
    }

    /**
     * '사이트 아이디'를 설정한다.
     * @param int|null $val
     * @return $this
     */
    public function setSiteIdAttribute(?int $val)
    {
        $this->attributes['site_id'] = $val;
        return $this;
    }

    /**
     * '타입'를 돌려준다.
     * @param string|null $val
     * @return Type|null
     */
    public function getTypeAttribute(?string $val): ?Type
    {
        return is_null($val) ? null : new Type($val);
    }

    /**
     * '타입'를 설정한다.
     * @param Type|null $val
     * @return $this
     */
    public function setTypeAttribute(?Type $val)
    {
        $this->attributes['type'] = is_null($val) ? null : (string)$val;
        return $this;
    }

    /**
     * '삭제유무'를 돌려준다.
     * @param bool $val
     * @return bool
     */
    public function getIsDeleteRecordingAttribute(bool $val): bool
    {
        return $val;
    }

    /**
     * '삭제유무'를 설정한다.
     * @param bool $val
     * @return $this
     */
    public function setIsDeleteRecordingAttribute(bool $val)
    {
        $this->attributes['is_delete_recording'] = $val;
        return $this;
    }

    /**
     * 호정보 기록을 시작한다.
     * @param Type $type
     * @param int $siteId
     * @param Carbon $createdAt
     * @param PhoneNumber $intermediateNo
     * @param PhoneNumber $callerNo
     * @param int $callerId
     * @param PhoneNumber|null $calleeNo
     * @param int|null $calleeId
     * @return $this
     */
    public function start(Type $type, int $siteId, Carbon $createdAt, PhoneNumber $intermediateNo, PhoneNumber $callerNo, int $callerId, ?PhoneNumber $calleeNo, ?int $calleeId)
    {
        $this->type = $type;
        $this->site_id = $siteId;

        $this->cdr_regdt = $createdAt;
        $this->cs_date = $createdAt->format('Ymd');
        $this->cs_time = $createdAt->format('His');

        $this->ars_num = $intermediateNo;

        $this->ani = $callerNo;
//        $this->caller_no = $callerNo;
//        $this->caller_id = $callerId;
//        $this->callee_no = $calleeNo;
//        $this->callee_id = $calleeId;
        if ($type==Type::INBOUND) {
            $this->cus_tel = $calleeNo;
            $this->cus_id = $calleeId;
        } else {
            $this->cus_tel = $callerNo;
            $this->cus_id = $callerId;
        }

        $this->gubun = 'N';
        $this->rec_yn = 'N';
        $this->svc_duration = 0;

        $this->is_delete_recording = false;

        return $this;
    }

    /**
     * 호종료 처리를 한다.
     * @param Carbon $endedAt
     * @param Result $result
     * @param Cause $cause
     * @param string|null $filename
     * @param int|null $filesize
     */
    public function finish(Carbon $endedAt, Result $result, Cause $cause, string $filename = null, int $filesize = null)
    {
        $this->ce_date = $endedAt->format('Ymd');
        $this->ce_time = $endedAt->format('His');
        $this->call_result = $result;
        $this->cause = $cause;
        if ($this->call_result==Result::SUCCESS) {
            if (empty($this->ss_date)===false) {
                $this->svc_duration = $endedAt->diffInSeconds(Carbon::createFromFormat('Ymd His', $this->ss_date.' '.$this->ss_time));
                if (empty($filename)===false) {
                    $this->rec_yn = 'Y';
                    $this->etc_2 = $filename;
                    $this->etc_3 = $filesize;
                }
            }
        }
    }

    /**
     * 마지막 유저 입력값을 갱신한다.
     * @param SiteScenarioType $type
     * @param SiteScenarioDtmf $dtmf
     * @return $this
     */
    public function updateLastInput(SiteScenarioType $type, SiteScenarioDtmf $dtmf)
    {
        $this->etc_10 = [
            'type' => $type->getCode(),
            'dtmf' => $dtmf->getCode(),
            ];
        return $this;
    }

    /**
     * 발신자가 수신자와 통화연결이 되었다.
     *
     * @param int $callerId
     * @param PhoneNumber $callerNo
     * @param int $calleeId
     * @param PhoneNumber $calleeNo
     * @param Carbon|null $at
     */
    public function callerConnectedToCallee(int $callerId, PhoneNumber $callerNo, int $calleeId, PhoneNumber $calleeNo, ?Carbon $at = null)
    {
        $at = $at ?? Carbon::now();

        $this->ss_date = $at->format('Ymd');
        $this->ss_time = $at->format('His');

        if ($this->type==Type::INBOUND) {
            $this->cus_tel = $calleeNo;
            $this->cus_id = $calleeId;
        } else {
            $this->cus_tel = $callerNo;
            $this->cus_id = $callerId;
        }

        return $this;
    }

    /**
     * 비즈메세지가 보내졌음을 표기한다.
     */
    public function markBizmessageSented()
    {
        $this->gubun = 'Y';
    }

    /**
     * 녹취록 저장 폴더를 생성한다.
     * @return string
     * @throw \UnexpectedValueException
     */
    private function makeRecordingFileDirectory(): string
    {
        if (empty($this->ars_num) || empty($this->cs_date)) {
            throw new \UnexpectedValueException('폴더 생성에 실패했습니다.');
        }

        $dir = (new RecordingDirectoryNamePolicy())->apply($this);
        if (Storage::disk('nas')->exists($dir) === false) {
            if (Storage::disk('nas')->makeDirectory($dir) === false) {
                throw new \UnexpectedValueException('폴더 생성에 실패했습니다.');
            }
        }

        return $dir;
    }

    /**
     * 녹취록 파일을 다운로드 받고 실제 파일 경로를 돌려준다.
     * @return string|null
     * @throws Exception
     */
    public function downloadRecordingFile()
    {
        if (empty($this->cdr_idx) || empty($this->rec_result) || empty($this->call_result) || empty($this->cause) || empty($this->svc_duration) || empty($this->etc_2)) {
            return null;
        }

        $filename = (new InbiznetRecordingFilenamePolicy())->apply($this);
        if ($this->rec_result==='100') {
            return $filename;
        }

        $dir = (new RecordingDirectoryNamePolicy())->apply($this);
        if (Storage::disk('nas')->exists($dir) === false) {
            if (Storage::disk('nas')->makeDirectory($dir) === false) {
                throw new \UnexpectedValueException('폴더 생성에 실패했습니다.');
            }
        }

        try {
            (new HttpClient())->request('GET', $this->etc_2, [
                'on_headers' => function (ResponseInterface $response) {
                    if ($response->getStatusCode() !== 200) {
                        throw new Exception('API 통신중 오류가 발생 하였습니다.('.$response->getStatusCode().')');
                    }
                },
                'sink' => Storage::disk('nas')->path($filename),
            ]);
        } catch (Exception $e) {
            Log::channel('inbiznet-client')->info('siteId '.$this->site_id.' '.$e->getMessage());
            throw $e;
        }

        $this->recfile_name = $filename;
        $this->rec_result = '100';
        $this->rec_result_time = Carbon::now();

        return $filename;
    }
}
