<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use App\Bots\pozor_sosedi_bot\Models\Announcement;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;
use Romanlazko\Telegram\Exceptions\TelegramUserException;

class IrrelevantAnnouncement extends Command
{
    public static $command = 'irrelevant';

    public static $title = [
        'ru' => 'Не актуально',
        'en' => 'Irrelevant'
    ];

    public static $usage = ['irrelevant'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $announcement = Announcement::findOr($updates->getInlineData()?->getAnnouncementId(), function () {
            throw new TelegramUserException("Объявление не найдено");
        });

        if ($announcement->status !== 'published' AND $announcement->status !== 'new') {
            throw new TelegramUserException("Объявление уже не актуально.");
        }

        $announcement->update([
            'status' => 'irrelevant'
        ]);

        BotApi::answerCallbackQuery([
            'callback_query_id' => $updates->getCallbackQuery()->getId(),
            'text'              => "Вам больше не смогут писать по поводу этого объявления",
            'show_alert'        => true
        ]);

        return $this->bot->executeCommand(MenuCommand::$command);
    }
}
