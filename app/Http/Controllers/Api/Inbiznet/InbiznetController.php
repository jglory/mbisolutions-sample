<?php


namespace App\Http\Controllers\Api\Inbiznet;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Handlers\Handler;
use App\Models\Transformers\Transformer;

use App\Http\Transformers\ApiTransformer;

use App\Http\Requests\Inbiznet\CreateCdr as CreateCdrRequest;
use App\Http\Transformers\Inbiznet\CreateCdr as CreateCdrTransformer;
use App\Commands\SiteCdrPartition\CreateCdr as CreateCdrCommand;
use App\Handlers\SiteCdrPartition\CreateCdr as CreateCdrHandler;



/**
 * Class InbiznetController
 * @package App\Http\Controllers\Api\Bizmessage
 */
class InbiznetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/inbiznet/site/{siteId}/cdr",
     *     tags={"인비즈넷"},
     *     summary="인비즈넷 호 데이터 생성",
     *     description="인비즈넷 호 데이터를 생성하고 최초 진입 안내 멘트 시나리오를 돌려준다.",
     *     security={
     *         {"cookieAuth": {}}
     *     },
     *     operationId="InbiznetController::createCdr",
     *     @OA\Parameter(
     *          name="siteId",
     *          description="고객 사이트 아이디",
     *          in="path",
     *          required=true,
     *          example="5000000202",
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="성공",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/response-200"),
     *                      @OA\Schema(
     *                          @OA\Property(property="data", type="object", ref="#/components/schemas/Http-Transformers-Inbiznet-CreateCdr")
     *                      )
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="실패",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/response-422")
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(property="intermediateNo", type="string", minLength=9, maxLength=20, description="매개 번호", example="15996884"),
     *                  @OA\Property(property="callerNo", type="string", description="발신자(고객) 번호", example="01012345555"),
     *                  @OA\Property(property="caleeNo", type="string", description="수신자(상담원) 번호", example="0707000568"),
     *                  @OA\Property(property="startedAt", type="string", minLength=19, maxLength=19, description="통화시작 일시", example="2019-02-25 12:59:20")
     *             )
     *         )
     *     )
     * )
     *
     * 인비즈넷 호 데이터를 생성하고 최초 진입 안내 멘트 시나리오를 돌려준다.
     * @param CreateCdrRequest $request
     * @return mixed
     */
    public function createCdr(CreateCdrRequest $request)
    {
        $startTime = microtime(true);
        try {
            $command = $request->getCommand();
            $data = (new CreateCdrHandler())->process($command);

            return (new CreateCdrTransformer())->process($data);
        } catch (\Exception $e) {
            return (new CreateCdrTransformer())->process($e);
        } finally {
            $endTime = microtime(true);
            Log::channel('inbiznet')->info(__METHOD__.' : perf_mon:'.(microtime(true) - $startTime));
        }
    }
}