<?php

namespace App\Bots\pozor_sosedi_bot\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Romanlazko\Telegram\Models\TelegramChat;

class Announcement extends Model
{
    use HasFactory; use SoftDeletes;

    protected $guarded = [];

    public function photos()
    {
        return $this->hasMany(AnnouncementPhoto::class, 'announcement_id', 'id');
    }

    public function telegram_chat()
    {
        return $this->belongsTo(TelegramChat::class, 'telegram_chat_id', 'id');
    }
}
