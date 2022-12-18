<?php


namespace App\Domains\SiteCdrPartition\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;



class DeleteRecordingFiles
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var array */
    private $cdrIds;

    /**
     * DeleteRecordingFiles constructor.
     *
     * @param array $cdrIds
     */
    public function __construct(array $cdrIds)
    {
        $this->cdrIds = $cdrIds;
    }

    /**
     * @return array
     */
    public function getCdrIds(): array
    {
        return $this->cdrIds;
    }

}