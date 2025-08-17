<?php

namespace App\Jobs;

use App\Models\LinkClick;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AcessLinkJob implements ShouldQueue
{
    use Queueable;

    protected $acessData;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->acessData = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        LinkClick::create($this->acessData);
    }
}
