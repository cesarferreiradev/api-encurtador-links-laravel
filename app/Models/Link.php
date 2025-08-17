<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /** @use HasFactory<\Database\Factories\LinkFactory> */
    use HasFactory, HasUlids;

    protected $table = 'links';
    protected $primaryKey = 'id_link';
    protected $fillable = [
        'original_url',
        'short_url',
        'expires_at',
        'code_user'
    ];
}
