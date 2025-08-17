<?php

namespace App\Jobs;

use App\Models\Link;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessLinkJob implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $create = Link::create($this->data);

        if (!$create) {
            Log::alert('Link não criado', [
                'data' => $this->data,
                'create' => $create
            ]);
        }

        Log::info('Link criado', [
            'data' => $this->data,
        ]);
    }
}
