<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\AdminCommands;

use Romanlazko\Telegram\App\BotApi;
use App\Bots\pozor_sosedi_bot\Events\AnnouncementPublished;
use App\Bots\pozor_sosedi_bot\Models\Announcement;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Config;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;
use Romanlazko\Telegram\Exceptions\TelegramException;
use Romanlazko\Telegram\Exceptions\TelegramUserException;

class PublicAnnouncement extends Command
{
    public static $command = 'public';

    public static $title = [
        'ru' => 'Публикуем',
        'en' => 'Public',
    ];

    public static $usage = ['public'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $announcement = Announcement::findOr($updates->getInlineData()?->getAnnouncementId(), function () {
            throw new TelegramUserException("Объявление не найдено");
        });

        if ($announcement->status !== 'new') {
            throw new TelegramUserException("Объявление уже обработано");
        }

        try {
            $response = BotApi::sendMessageWithMedia([
                'text'                      => $this->prepare($announcement->toArray()),
                'chat_id'                   => Config::get($announcement->city),
                'media'                     => $announcement->photos->pluck('file_id')->toArray() ?? null,
                'parse_mode'                => 'HTML',
                'disable_web_page_preview'  => 'true',
            ]);

            if ($response->getOk()) {
                $announcement->update([
                    'status' => 'published'
                ]);
        
                event(new AnnouncementPublished($announcement));
            }
        }
        catch (TelegramException $exception) {
            throw new TelegramUserException("Ошибка публикации: {$exception->getMessage()}");
        }

        return $this->bot->executeCommand(MenuCommand::$command);
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

        if (isset($notes['id'])) {
            $text[] = "<a href='https://t.me/". Config::get('bot_username') ."?start=announcement={$notes['id']}'>🔗Контакт</a> (<i>Перейди по ссылке и нажми <b>Начать</b></i>)";
        }

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
