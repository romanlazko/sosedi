<?php

namespace App\Bots\pozor_sosedi_bot\Listeners;

use App\Bots\pozor_sosedi_bot\Commands\UserCommands\MenuCommand;
use App\Bots\pozor_sosedi_bot\Commands\UserCommands\ShowMyAnnouncement;
use App\Bots\pozor_sosedi_bot\Events\AnnouncementPublished;
use Romanlazko\Telegram\App\BotApi;

class SendToUserAnnouncementPublishedNotification
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
    public function handle(AnnouncementPublished $event): void
    {
        $announcement = $event->announcement;

        $buttons = BotApi::inlineKeyboard([
            [array($announcement->title ?? $announcement->caption, ShowMyAnnouncement::$command, $announcement->id)],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ], 'announcement_id');

        BotApi::sendMessage([
            'chat_id'       => $announcement->telegram_chat->chat_id,
            'text'          => "Ваше объявление опубликовано",
            'reply_markup'  => $buttons,
            'parse_mode'    => 'HTML',
        ]);
    }
}
