<?php

namespace App\Http\Controllers;

use App\Jobs\AcessLinkJob;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Support\Carbon;

class RedirectController extends Controller
{
    public function __construct(protected LinkService $linkService)
    {
    }

    public function redirect($short)
    {
        $link = Link::where('short_url', $short)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhereDate('expires_at', '>=', Carbon::today());
            })
            ->firstOrFail();

        $data = [
            'link_id'    => $link->id_link,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referer'    => request()->header('referer'),
        ];

        AcessLinkJob::dispatch($data)->onQueue('database');

        return redirect($link->original_url);
    }
}
