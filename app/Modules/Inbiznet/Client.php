<?php


namespace App\Modules\Inbiznet;

use App\Models\ExternalApi\Http\Client as Base;

use App\Modules\Inbiznet\Requests\TtsListening as TtsListeningRequest;
use App\Modules\Inbiznet\Senders\TtsListening as TtsListeningSender;

use App\Modules\Inbiznet\Requests\TtsDownload as TtsDownloadRequest;
use App\Modules\Inbiznet\Senders\TtsDownload as TtsDownloadSender;

use App\Modules\Inbiznet\Requests\Signup as SignupRequest;
use App\Modules\Inbiznet\Senders\Signup as SignupSender;

use App\Modules\Inbiznet\Requests\TerminateServices as TerminateServicesRequest;
use App\Modules\Inbiznet\Senders\TerminateServices as TerminateServicesSender;

use App\Modules\Inbiznet\Requests\SiteSubscribed as SiteSubscribedRequest;
use App\Modules\Inbiznet\Senders\SiteSubscribed as SiteSubscribedSender;

class Client extends Base
{
    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->senders = [
            TtsListeningRequest::class => new TtsListeningSender(),
            TtsDownloadRequest::class => new TtsDownloadSender(),
            SignupRequest::class => new SignupSender(),
            TerminateServicesRequest::class => new TerminateServicesSender(),
            SiteSubscribedRequest::class => new SiteSubscribedSender(),
        ];
    }
}