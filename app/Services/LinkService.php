<?php

namespace App\Services;
use App\Models\Link;
use Sqids\Sqids;

class LinkService
{
    private $sqids;

    public function __construct()
    {
        $this->sqids = new Sqids(
            minLength: 4
        );
    }

    public function shorten(string $url): string
    {
        do {
            $hash = $this->sqids->encode([rand(1,100), crc32($url)]);
        } while (Link::where('short_url', $hash)->exists());

        return $hash;
    }

    public function registerClick(string $code)
    {

    }
}
