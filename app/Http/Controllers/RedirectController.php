<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __construct(protected LinkService $linkService)
    {
    }

    public function redirect($link)
    {
        $link = Link::where('short_url', $link)->firstOrFail();

        return redirect($link->original_url);
    }
}
