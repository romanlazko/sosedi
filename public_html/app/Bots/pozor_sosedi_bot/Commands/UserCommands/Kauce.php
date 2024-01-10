<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Kauce extends Command
{
    public static $command = 'kauce';

    public static $title = '';

    public static $usage = ['kauce'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitKauce::$expectation);
        
        $buttons = BotApi::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $data = [
            'text'          => "Укажи размер *залога* (кауце) на недвижимость, которую ты хочешь *сдавать*."."\n\n"."_Если залог (кауце) не требуется, пришли 0_",
            'chat_id'       => $updates->getChat()->getId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons,
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ];

        return BotApi::returnInline($data);
    }




}
