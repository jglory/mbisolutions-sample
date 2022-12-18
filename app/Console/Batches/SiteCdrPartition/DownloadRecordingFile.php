<?php

namespace App\Console\Batches\SiteCdrPartition;

use Illuminate\Console\Command;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Jobs\ProcessCommand as ProcessCommandJob;

use App\Commands\SiteCdrPartition\DownloadRecordingFile as SiteCdrPartitionDownloadRecordingFileCommand;
use App\Handlers\SiteCdrPartition\DownloadRecordingFile as SiteCdrPartitionDownloadRecordingFileHandler;

use Illuminate\Support\Facades\Validator;

use App\Domains\Site\Values\IvrType as SiteIvrType;



class DownloadRecordingFile extends Command
{
    const SIGNATURE = 'batches:cdr-download-recording-file {date?}';
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

        $data = [
            'date' => $this->argument('date'),
        ];

        $rules = [
            'date' => 'nullable|date_format:Y-m-d'
        ];

        $messages = [
            'date.date_format' => '\''.$data['date'].'\' 일시 입력값이 비정상적입니다.',
        ];

        $result = Validator::make($data, $rules, $messages);
        try {
            if ($result->fails()) {
                throw new \Exception($result->errors()->first());
            }

            // 인자가 없을 경우 전일로 날짜 설정
            if (empty($data['date'])) {
                $dt = Carbon::createFromFormat('Y-m-d H:i:s', (clone $now)->subDay()->format('Y-m-d').' 00:00:00');
            } else {
                $dt = Carbon::createFromFormat('Y-m-d H:i:s', $data['date'].' 00:00:00');
            }
            $data['date'] = $dt->format('Y-m-d');

            $rdset = DB::table('t_cdr_partition as c')
                ->where('cdr_regdt', '>=', $dt->format('Y-m-d H:i:s'))
                ->where('cdr_regdt', '<', (clone $dt)->addDay(1)->format('Y-m-d H:i:s'))
                ->where('svc_duration', '>', 0)
                ->get();
            if ($rdset->isEmpty()===false) {
                /** @var \stdClass $rd */
                foreach ($rdset as $rd) {
                    // queue 사용 버전
                    ProcessCommandJob::dispatch(
                        new SiteCdrPartitionDownloadRecordingFileCommand($rd->site_id, $rd->cdr_idx),
                        new SiteCdrPartitionDownloadRecordingFileHandler()
                    );

                    // 순차 다운로드 버전
                    //try {
                    //    (new SiteCdrPartitionDownloadRecordingFileHandler())->process(
                    //        new SiteCdrPartitionDownloadRecordingFileCommand($rd->site_id, $rd->cdr_idx)
                    //    );
                    //} catch (\Throwable $e) {
                    //    Log::error(__METHOD__.' : '.$rd->site_id.', '.$rd->cdr_idx);
                    //}
                }
            }

            Log::channel('console')->info($this->signature.'. '.$now->format('Y-m-d H:i:s.u').' ~ '.Carbon::now()->format('Y-m-d H:i:s.u').'. 녹취록 다운로드 배치 : '.$data['date'].PHP_EOL);
        }catch (\Exception $e){
            Log::channel('console')->info($this->signature.'. '.$now->format('Y-m-d H:i:s.u').' ~ '.Carbon::now()->format('Y-m-d H:i:s.u').'. 녹취록 다운로드 배치 : '.$data['date'].PHP_EOL.$e->getMessage());
            $this->error($e->getMessage());
        }
    }
}
