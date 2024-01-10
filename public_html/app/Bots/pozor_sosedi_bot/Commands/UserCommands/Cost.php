<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Cost extends Command
{
    public static $command = 'cost';

    public static $title = '';

    public static $usage = ['cost'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitCost::$expectation);

        $notes = $this->getConversation()->notes;

        switch ($notes['type']) {
            case 'buy':
                $text = "Укажи *стоимость* в кронах, за которую ты расчитываешь *купить*."."\n\n".
                            "Пример: __5000000__";
                break;
            case 'sell':
                $text = "Укажи *стоимость* в кронах той недвижимости, которую ты хочешь *продать*."."\n\n".
                            "Пример: __5000000__";
                break;
            case 'rent':
                $text = "Укажи в кронах размер ежемесячной *оплаты*, за которую ты расчитываешь *снимать*."."\n\n".
                            "Пример: __8000__";
                break;
            case 'lease':
                $text = "Укажи в кронах размер ежемесячной *оплаты* той недвижимости, которую ты хочешь *сдать*."."\n\n".
                            "Пример: __8000__";
                break;
        }
        
        $buttons = BotApi::inlineKeyboard([
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $data = [
            'text'          => $text,
            'chat_id'       => $updates->getChat()->getId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons,
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
        ];

        return BotApi::returnInline($data);
    }




}
