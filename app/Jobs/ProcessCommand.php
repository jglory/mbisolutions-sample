<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Command\Command;
use App\Models\Handler\Handler;



/**
 * '커맨트 처리' Job 클래스
 * Class ProcessCommand
 * @package App\Jobs
 */
class ProcessCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const QUEUE_DEFAULT = 'default';
    const QUEUE_CDRDOWNLOADRECORDINGFILE = 'cdr_download_recording_file';

    /** @var Command 커맨드 객체 */
    protected $command;
    /** @var Handler 핸들러 객체 */
    protected $handler;

    /**
     * Create a new job instance.
     *
     * @param Command $command
     * @param Handler $handler
     * @return void
     */
    public function __construct($command, $handler)
    {
        $this->command = $command;
        $this->handler = $handler;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::channel('worker')->info([
            __METHOD__ => [
                'type' => 'processing',
                'at' => Carbon::now(),
                'command' => $this->command,
                'handler' => get_class($this->handler),
            ]
        ]);

        $this->handler->process($this->command);

        Log::channel('worker')->info([
            __METHOD__ => [
                'type' => 'processed',
                'at' => Carbon::now(),
                'command' => $this->command,
                'handler' => get_class($this->handler),
            ]
        ]);
    }
}
