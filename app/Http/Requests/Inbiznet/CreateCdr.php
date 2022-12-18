<?php


namespace App\Http\Requests\Inbiznet;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Requests\Request;

use App\Commands\SiteCdrPartition\CreateCdr as Command;

use App\Values\PhoneNumber;


/**
 * '호 데이터 생성 (SDCA-I-CDR-001)' Request 클래스
 * Class CreateCdr
 * @package App\Http\Requests\Inbiznet
 */
class CreateCdr extends Request
{
    /**
     * @inheritdoc
     * @return mixed|void
     */
    public function getCommand()
    {
        $rules = [
            'siteId' => 'required|integer',
            'intermediateNo' => 'required|regex:/^[0-9-]{6,17}/',
            'callerNo' => 'required|regex:/^[0-9-]{6,17}/',
            'startedAt' => 'required|date_format:Y-m-d H:i:s'
        ];

        $messages = [
            'siteId.required' => '사이트 아이디를 입력하여 주십시오.',
            'siteId.integer' => '사이트 아이디 입력값이 비정상적입니다.',
            'intermediateNo.required' => '매개 번호를 입력하여 주십시오.',
            'intermediateNo.regex' => '매개 번호 입력값이 비정상적입니다.',
            'callerNo.required' => '발신자 번호를 입력하여 주십시오.',
            'callerNo.regex' => '발신자 번호 입력값이 비정상적입니다.',
            'startedAt.required' => '통화시작 일시를 입력하여 주십시오.',
            'startedAt.date_format' => '통화시작 일시 입력값이 비정상적입니다.',
        ];

        $data = [
            'siteId' => $this->route()->parameter('siteId'),
            'intermediateNo' => $this->json('intermediateNo'),
            'callerNo' => $this->json('callerNo'),
            'startedAt' => $this->json('startedAt'),
        ];

        Log::channel('inbiznet')->info([__METHOD__ => $data]);

        $result = Validator::make($data, $rules, $messages);
        if ($result->fails()) {
            throw new \Exception($result->errors()->first());
        }

        return new Command($data['siteId'], new PhoneNumber($data['intermediateNo']), new PhoneNumber($data['callerNo']), Carbon::createFromFormat('Y-m-d H:i:s', $data['startedAt']));
    }
}