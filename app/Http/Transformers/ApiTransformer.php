<?php


namespace App\Http\Transformers;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;



/**
 * 처리를 하지 않는 트랜스포머 클래스
 * Class ApiTransformer
 * @package App\Http\Transformers
 */
abstract class ApiTransformer extends Transformer
{
    /** @var int 성공 코드 */
    protected $successCode;
    /** @var int 실패 코드 */
    protected $failCode;
    /** @var string 로깅 채널명 */
    protected $loggingChannel;

    /**
     * ApiTransformer constructor.
     * @param int $successCode
     * @param int $failCode
     * @param string $loggingChannel
     */
    public function __construct(int $successCode = 200, int $failCode = 422, string $loggingChannel = 'stack')
    {
        $this->successCode = $successCode;
        $this->failCode = $failCode;
        $this->loggingChannel = $loggingChannel;
    }

    /**
     * '성공 코드'를 돌려준다.
     * @return int
     */
    public function getSuccessCode(): int
    {
        return $this->successCode;
    }

    /**
     * '실패 코드'를 돌려준다.
     * @return int
     */
    public function getFailCode(): int
    {
        return $this->failCode;
    }

    /**
     * '로깅 채널'을 돌려준다.
     * @return string
     */
    public function getLoggingChannel(): string
    {
        return $this->loggingChannel;
    }

    /**
     * success 데이터를 처리한다.
     * @param $data
     * @return array|null
     */
    protected function processSuccess($data): ?array
    {
        return $data;
    }

    /**
     * fail 데이터를 처리한다.
     * @param $data
     * @return array
     */
    protected function processFail($data): array
    {
        return [
            'code' => $data->getCode(),
            'message' => $data->getMessage(),
        ];
    }

    /**
     * bigint 컬럼을 string 으로 변환한다.
     * @param array $transformed
     * @return array
     */
    protected function convertBigint(array $transformed)
    {
        foreach ($transformed as $key => $val) {
            if (is_int($val)) {
                $len = strlen($key);
                if (
                    ($len===2 && $key==='id')
                    || ($key[$len-3]==='_' && $key[$len-2]==='i' && $key[$len-1]==='d')
                    || (
                        (($key[$len-3]>='a' && $key[$len-3]<='z') || ($key[$len-3]>='0' && $key[$len-3]<='9'))
                        && $key[$len-2]==='I' && $key[$len-1]==='d'
                    )
                ) {
                    $transformed[$key] = (string)$val;
                }
            } elseif (is_array($val)) {
                $transformed[$key] = $this->convertBigint($val);
            }
        }

        return $transformed;
    }

    /**
     * @inheritDoc
     * @param $data
     * @throws \Exception
     */
    public function process($data)
    {
        /** @var JsonResponse $response */
        $response = null;

        Carbon::serializeUsing(function($carbon) {
            return $carbon->format('Y-m-d H:i:s');
        });
        try {
            $class = get_class($this);
            if ($data instanceof \Exception) {
                $transformed = $this->processFail($data);
                Log::channel($this->loggingChannel)
                    ->info([
                        $class . '::process' => [
                            'result' => 'fail',
                            'data' => $transformed
                        ]
                    ]);
                $response = response()->json(
                    [
                        'result' => 'fail',
                        'data' => $this->processFail($data),
                    ],
                    $this->failCode
                );
            } else {
                // 브라우저가 json 컬럼에서 bigint를 잘못 해석하는 오류가 있어 id 의 경우 string으로 치환하여 내려준다.
                $transformed = $this->processSuccess($data);
                Log::channel($this->loggingChannel)
                    ->info([
                        $class . '::process' => [
                            'result' => 'success',
                            'data' => $transformed
                        ]
                    ]);
                $response = response()->json(
                    [
                        'result' => 'success',
                        'data' => $transformed
                    ],
                    $this->successCode
                );
            }
        } finally {
            Carbon::serializeUsing(null);
            if ($data instanceof \Exception === false) {
                $response->setData($this->convertBigint($response->getData(true)));
            }
        }

        return $response;
    }
}