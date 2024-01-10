<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use App\Bots\pozor_sosedi_bot\Models\Announcement;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Commands\UserCommands\AdvertisementCommand;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;
use Romanlazko\Telegram\Exceptions\TelegramUserException;

class GetOwnerContact extends Command
{
    public static $command = 'get_owner_contact';

    public static $title = '';

    public static $pattern = "/^(\/start\s)(announcement)=(\d+)$/";

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        // $this->bot->executeCommand(AdvertisementCommand::$command);

        preg_match(static::$pattern, $updates->getMessage()?->getCommand(), $matches);

        $announcement = Announcement::findOr($matches[3] ?? null, function () {
            throw new TelegramUserException("Объявление не найдено");
        });

        if ($announcement->status !== 'published' AND $announcement->status !== 'new') {
            throw new TelegramUserException("Объявление уже не актуально");
        }

        $announcement->increment('views');
        
        return $this->sendAnnouncementContact($announcement);
    }

    private function sendAnnouncementContact($announcement)
    {
        $buttons = BotApi::inlineKeyboardWithLink([
            'text'  => "👤 Контакт на автора", 
            'url'   => "tg://user?id={$announcement->telegram_chat->chat_id}"
        ]);

        $text = implode("\n\n", [
            "<b>Вот контакт на автора объявления:</b>",
            $this->prepare($announcement)
        ]);

        return BotApi::sendMessage([
            'text'                      => $text,
            'reply_markup'              => $buttons,
            'chat_id'                   => $this->updates->getChat()->getId(),
            'parse_mode'                => 'HTML',
            'disable_web_page_preview'  => true,
        ]);
    }

    private function prepare($notes)
    {
        $text = [];

        if (isset($notes['type'])) {
            $types = [
                'buy' => '#куплю',
                'sell' => '#продам',
                'rent' => '#сниму',
                'lease' => '#сдам',
            ];

            $text[] = $types[$notes['type']];
        }

        if (isset($notes['title'])) {
            $text[] = "<b>{$notes['title']}</b>";
        }

        if (isset($notes['caption'])) {
            $text[] = $notes['caption'];
        }

        $params = [];

        if (isset($notes['term']) AND $notes['term'] != 0) {
            $terms = [
                'long' => "как можно дольше",
                '3m' => "3 месяца",
                '6m' => "6 месяцев",
                '12m' => "12 месяцев"
            ];

            if (isset($terms[$notes['term']])) {
                $params[] = "<i>Срок:</i> ".$terms[$notes['term']];
            }else {
                $params[] = "<i>Срок:</i> ".$notes['term'];
            }
        }

        if (isset($notes['cost'])) {
            $params[] = "<i>Стоимость:</i> {$notes['cost']} CZK";
        }

        if (isset($notes['kauce'])) {
            $params[] = "<i>Залог:</i> {$notes['kauce']} CZK";
        }

        if (isset($notes['location'])) {
            $params[] = "<i>Локация:</i> ".$notes['location'];
        }

        $text[] = implode("\n", $params);

        if (isset($notes['category'])) {
            $categories = [
                'f' => '#квартира',
                'h' => '#дом',
                'r' => '#комната',
                's' => '#место_в_комнате',
            ];

            $text[] = implode(' ', array_map(function ($char) use ($categories) {
                return $categories[$char];
            }, array_filter(str_split($notes['category']), function ($char) {
                return $char != ':';
            })));
        }

        return implode("\n\n", $text);
    }
}
