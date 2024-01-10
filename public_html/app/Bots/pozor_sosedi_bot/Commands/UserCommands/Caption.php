<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Caption extends Command
{
    public static $command = 'caption';

    public static $title = [
        'ru' => "Описание товара",
        'en' => "Caption"
    ];

    public static $usage = ['caption'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitCaption::$expectation);

        $buttons = BotApi::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')],
        ]);

        $data = [
            'text'          => $this->createText(),
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons
        ];

        return BotApi::returnInline($data);
    }

    private function createText(): string
    {
        $notes  = $this->getConversation()->notes;

        switch ($notes['type']) {
            case 'buy':
                $trade = "купить";
                break;
            case 'sell':
                $trade = "продать";
                break;
            case 'rent':
                $trade = "снять";
                break;
            case 'lease':
                $trade = "сдать";
                break;
        }

        return "Напиши описание объекта, который ты хочешь *{$trade}*."."\n\n".
        "Опиши жилищные условия (сколько комнат, какая мебель, бытовая техника, есть ли балкон/кладовка и тд.)"."\n\n".
        "_Максимально 600 символов_";
    }
}
