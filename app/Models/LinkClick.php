<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkClick extends Model
{
    /** @use HasFactory<\Database\Factories\LinkClickFactory> */
    use HasFactory;

    protected $table = 'link_clicks';
    protected $primaryKey = 'id_link_click';
    protected $fillable = [
        'link_id',
        'ip_address',
        'user_agent',
        'referer',
    ];
}
