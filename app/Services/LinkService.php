<?php

namespace App\Services;
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

    public function shorten(string $url)
    {
        return $this->sqids->encode([rand(1,100), crc32($url)]);
    }

    public function resolve(string $code)
    {

    }

    public function registerClick(string $code)
    {

    }
}
