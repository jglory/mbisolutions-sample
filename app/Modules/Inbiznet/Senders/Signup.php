<?php


namespace App\Modules\Inbiznet\Senders;

use GuzzleHttp\Client as GuzzleHttp;
use GuzzleHttp\Psr7\Request as GuzzleHttpRequest;

use App\Models\ExternalApi\Http\Request;
use App\Models\ExternalApi\Http\Response;
use App\Models\ExternalApi\Http\SenderInterface;
use App\Modules\Inbiznet\Requests\Signup as SignupRequest;
use App\Values\Http\Method as HttpMethod;

use App\Modules\Inbiznet\Responses\Signup as SignupResponse;

class Signup implements SenderInterface
{
    /**
     * @param Request $request
     *
     * @return Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(Request $request): Response
    {
        $url = env('INBIZNET_URL').$request->getCmd();
        $headers = ['application/json'];
        $body = json_encode([
            'cmd' => $request->getCmd(),
            'id' => strval($request->getId()),
            'at' => $request->getAt()->format('YmdHis'),
            'siteId' => $request->getSiteId(),
            'name' => $request->getName(),
            'arsNo' => $request->getArsNo(),
            'intermediateNo' => $request->getIntermediateNo(),
            'ivrNumber' => $request->getIvrNumber(),
        ], JSON_UNESCAPED_UNICODE);

        $result = (new GuzzleHttp())->send(new GuzzleHttpRequest(HttpMethod::POST, $url, $headers, $body));
        if ($result->getStatusCode()!==200) {
            throw new \Exception('API 호출에 실패했습니다. '.$result->getStatusCode().' 반환');
        }
        $decoded = json_decode($result->getBody()->getContents(), true);

        if (empty($decoded) || isset($decoded['result'])==false) {
            throw new \Exception('API 응답이 비정상적입니다.');
        }

        return new SignupResponse($decoded['result']['message'], $decoded['result']['code'], $decoded['cmd'], $decoded['id'], $decoded['at']);
    }
}