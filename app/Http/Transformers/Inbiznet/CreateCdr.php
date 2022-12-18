<?php


namespace App\Http\Transformers\Inbiznet;


use App\Http\Transformers\ApiTransformer;



/**
 *  @OA\Schema(
 *      schema="Http-Transformers-Inbiznet-CreateCdr",
 *      @OA\Property(property="id", type="string", description="호 정보 아이디", example="169753249916649472"),
 *      @OA\Property(property="scenario", type="object",
 *          @OA\Property(property="id", type="string", description="시나리오 아이디", example="169753249916649472"),
 *          @OA\Property(property="type", type="string", enum={"O", "F"}, minLength=1, maxLength=1, description="시나리오 타입 코드. O:업무 시간, F:업무 외 시간", example="O"),
 *          @OA\Property(property="dtmf", type="string", minLength=1, maxLength=1, description="입력 번호. ARS에서 사용자가 누르는 번호"),
 *          @OA\Property(property="action", type="string", enum={"T", "C", "O", "S"}, description="배정 액션", example="C"),
 *          @OA\Property(property="disabled", type="boolean", description="비활성화 여string부", example="false"),
 *          @OA\Property(property="attachedNos", type="array",
 *              @OA\Items(type="string", description="착신 번호", example="07048492565"),
 *          ),
 *          @OA\Property(property="end", type="boolean", description="통화종료 여부", example="true"),
 *          @OA\Property(property="ment", type="object",
 *              @OA\Property(property="INTRO", type="string", description="안내멘트", example="안녕하세요. 에어컨 세탁기 청소업체 현란한드릴 입니다. 전화상담을 원하시면 0번을, 카카오톡 상담을 원하시면 1번을 눌러 주세요. 카카오톡을 통해 보다 빠르게 이용할 수 있습니다. 전화 상담은 평일 오전10시부터 오후7시까지입니다. 다시 듣고 싶으시면 별표를 눌러주십시오."),
 *              @OA\Property(property="MISMATCH", type="string", description="잘못입력", example="잘못 누르셨습니다."),
 *              @OA\Property(property="RETRY", type="string", description="다시듣기", example="안녕하세요. 에어컨 세탁기 청소업체 현란한드릴 입니다. 전화상담을 원하시면 0번을, 카카오톡 상담을 원하시면 1번을 눌러 주세요. 카카오톡을 통해 보다 빠르게 이용할 수 있습니다. 전화 상담은 평일 오전10시부터 오후7시까지입니다. 다시 듣고 싶으시면 별표를 눌러주십시오."),
 *              @OA\Property(property="INPUT_TIMEOUT", type="string", description="입력 시간 타임아웃", example="입력 시간을 초과하였습니다. 다시 듣고 싶으시면 별표를 눌러주십시오."),
 *              @OA\Property(property="CANCEL", type="string", description="취소", example="취소하였습니다."),
 *              @OA\Property(property="exceed", type="string", description="횟수초과", example="입력횟수를 초과하였습니다."),
 *          )
 *      )
 * )
 *
 * Class CreateCdr
 * @package App\Http\Transformers\Inbiznet
 */
class CreateCdr extends ApiTransformer
{
    /**
     * CreateCdr constructor.
     * @param int $successCode
     * @param int $failCode
     * @param string $loggingChannel
     */
    public function __construct(int $successCode = 200, int $failCode = 422, string $loggingChannel = 'stack')
    {
        parent::__construct($successCode, $failCode, 'inbiznet');
    }

    /**
     * @inheritDoc
     * @param array $data
     * @throws \Exception
     */
    protected function processSuccess($data): array
    {
        $scenario = $data['scenario']->jsonSerialize();
        $scenario['end'] = $data['end'];
        $ment = $scenario['ment'];
        $scenario['ment'] = [
            "INTRO" => $ment,
            "MISMATCH" => $data['ments']['MISMATCH'],
            "RETRY" => $ment,
            "INPUT_TIMEOUT" => $data['ments']['INPUT_TIMEOUT'],
            "CANCEL" => $data['ments']['CANCEL'],
            "EXCEED" => $data['ments']['EXCEED'],
            "AFTER" => $data['ments']['AFTER']
        ];
        return [
            'id' => $data['id'],
            'scenario' => $scenario,
        ];
    }
}