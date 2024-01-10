<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use App\Bots\pozor_sosedi_bot\Http\DataTransferObjects\Announcement;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;
use Romanlazko\Telegram\Exceptions\TelegramException;
use Romanlazko\Telegram\Exceptions\TelegramUserException;

class ShowAnnouncement extends Command
{
    public static $command = 'show';

    public static $title = '';

    public static $usage = ['show'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $notes = $this->getConversation()->notes;

        try {
            BotApi::sendMessageWithMedia([
                'text'                      => $this->prepare($notes),
                'chat_id'                   => $updates->getChat()->getId(),
                'media'                     => $notes['photos'] ?? null,
                'parse_mode'                => 'HTML',
                'disable_web_page_preview'  => 'true',
            ]);
        }
        catch (TelegramException $exception) {
            throw new TelegramUserException("Ошибка публикации: {$exception->getMessage()}");
        }
        
        return $this->sendConfirmMessage($updates);
    }

    private function sendConfirmMessage(Update $updates): Response
    {
        $buttons = BotApi::inlineKeyboard([
            [array('Публикуем', PublicAnnouncement::$command, '')],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')],
        ]);

        return BotApi::sendMessage([
            'text'          => "Так будет выглядеть твое объявление." ."\n\n". "*Публикуем?*", 
            'chat_id'       => $updates->getChat()->getId(),
            'parse_mode'    => 'Markdown',
            'reply_markup'  => $buttons
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
