<?php

namespace App\Bots\pozor_sosedi_bot\Listeners;

use App\Bots\pozor_sosedi_bot\Events\AnnouncementRejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Romanlazko\Telegram\App\BotApi;

class SendToUserAnnouncementRejectedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(AnnouncementRejected $event): void
    {
        $announcement = $event->announcement;

        BotApi::sendMessage([
            'chat_id'       => $announcement->telegram_chat->chat_id,
            'text'          => "Ваше объявление отклонено", 
            'parse_mode'    => 'HTML',
        ]);
    }
}
