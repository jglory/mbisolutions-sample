<?php

namespace App\Modules\Broadcasting;


use Illuminate\Notifications\Messages\BroadcastMessage as Base;

use App\Transformers\Facades\BigintFilter;
use App\Transformers\Facades\SensitiveInformationFilter;



class BroadcastMessage extends Base
{
    /**
     * @inheritdoc
     *
     * @param  array  $data
     * @return void
     */
    public function __construct(array $data)
    {
        parent::__construct($this->transform($data));
    }

    /**
     * Set the message data.
     *
     * @param  array  $data
     * @return $this
     */
    public function data($data)
    {
        return $this->transform($data);
    }

    protected function transform(array $data)
    {
        $data = BigintFilter::process($data);
        $data = SensitiveInformationFilter::process($data);

        return $data;
    }
}
