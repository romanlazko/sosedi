<?php

namespace App\Bots\pozor_sosedi_bot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnouncementPhoto extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'file_id',
        'url'
    ];
}
