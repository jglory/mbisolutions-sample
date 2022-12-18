<?php

namespace App\Console\Commands\SiteCdrPartition;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

use App\Jobs\ProcessCommand as ProcessCommandJob;

use App\Commands\SiteCdrPartition\DownloadRecordingFile as SiteCdrPartitionDownloadRecordingFileCommand;
use App\Handlers\SiteCdrPartition\DownloadRecordingFile as SiteCdrPartitionDownloadRecordingFileHandler;
use Illuminate\Support\Facades\Validator;


class DownloadRecordingFile extends Command
{
    const SIGNATURE = 'sitecdrpartition:download-recording-file {siteId} {cdrId}';
    const DESCRIPTION = '호정보와 관련된 녹취록 파일을 미리 지정된 위치로 다운로드 한다.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = self::SIGNATURE;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = self::DESCRIPTION;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();

        $rules = [
            'siteId' => 'required|integer',
            'cdrId' => 'required|integer',
        ];

        $messages = [
            'siteId.required' => '사이트 아이디를 입력하여 주십시오.',
            'siteId.integer' => '사이트 아이디 입력값이 비정상적입니다.',
            'cdrId.required' => '호정보 아이디를 입력하여 주십시오.',
            'cdrId.integer' => '호정보 아이디 입력값이 비정상적입니다.',
        ];

        $data = [
            'siteId' => $this->argument('siteId'),
            'cdrId' => $this->argument('cdrId'),
        ];
        try{
            $result = Validator::make($data, $rules, $messages);
            if ($result->fails()) {
                throw new \Exception($result->errors()->first());
            }

            (new SiteCdrPartitionDownloadRecordingFileHandler())->process(
                new SiteCdrPartitionDownloadRecordingFileCommand($data['siteId'], $data['cdrId'])
            );
            Log::channel('console')->info($this->signature.'. '.$now->format('Y-m-d H:i:s.u').' ~ '.Carbon::now()->format('Y-m-d H:i:s.u').'. ['.$data['siteId'].', '.$data['cdrId'].'] 녹취록 다운로드'.PHP_EOL);
        }catch (\Exception $e){
            Log::channel('console')->info($this->signature.'. '.$now->format('Y-m-d H:i:s.u').' ~ '.Carbon::now()->format('Y-m-d H:i:s.u').'. ['. $data['siteId'].', '.$data['cdrId'].'] 녹취록 다운로드'.PHP_EOL.$e->getMessage());

            //에러 라인 출력
            $this->error($e->getMessage());
        }
    }
}
