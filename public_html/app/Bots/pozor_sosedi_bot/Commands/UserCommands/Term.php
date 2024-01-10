<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use App\Bots\pozor_sosedi_bot\Models\BaraholkaCategory;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Term extends Command
{
    public static $command = 'term';

    public static $title = '';

    public static $usage = ['term'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitTerm::$expectation);

        $buttons = BotApi::inlineKeyboard([
            [array('Как можно дольше', SaveTerm::$command, 'long')],
            [array('3 месяца', SaveTerm::$command, '3m')],
            [array('6 месяцев', SaveTerm::$command, '6m')],
            [array('12 месяцев', SaveTerm::$command, '12m')],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ], 'term');

        switch ($updates->getInlineData()->getType()) {
            case 'rent':
                $text = "На какой *срок* ты хочешь *снять* жилье?"."\n\n".
                        "*Выбери с помощью кнопок, либо напиши мне срок.*"."\n".
                        "Пример: _3 месяца, 6 месяцев и т.д._";

                break;
            case 'lease':
                $text = "На какой *срок* ты хочешь *сдать* жилье?"."\n\n".
                        "*Выбери с помощью кнопок, либо напиши мне срок.*"."\n".
                        "Пример: _3 месяца, 6 месяцев и т.д._"; 

                break;
        }

        $data = [
            'text'          => $text,
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons
        ];

        return BotApi::returnInline($data);
    }
}
