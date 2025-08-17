<?php

namespace App\Console\Commands;

use App\Jobs\DisableExpiredLinksJob;
use App\Models\Link;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class VerifiyExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verifiy-expired-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica os links que estão expirados e, envia para o job remover';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = Link::whereDate('expires_at', '<', Carbon::today())
            ->where('status', 'active')
            ->get();

        Log::info('Links expirados', [
            'links' => $expired
        ]);

        if (!$expired) {
            return false;
        }

        foreach ($expired as $link) {
            DisableExpiredLinksJob::dispatch($link)->onQueue('database');
        }
    }
}
