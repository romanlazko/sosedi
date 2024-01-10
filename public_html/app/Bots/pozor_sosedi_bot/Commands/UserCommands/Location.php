<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Location extends Command
{
    public static $command = 'location';

    public static $title = '';

    public static $usage = ['location'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $updates->getFrom()->setExpectation(AwaitLocation::$expectation);

        $notes = $this->getConversation()->notes;

        switch ($notes['type']) {
            case 'buy':
                $text = "Укажи *адрес*, *район* или *часть города*, в котором тебе хотелось бы *купить* недвижимость."."\n\n".
                        "_Максимально 50 символов_";
                break;
            case 'sell':
                $text = "Укажи *адрес*, *район* или *часть города*, в котором ты *продаешь* недвижимость."."\n\n".
                        "_Максимально 50 символов_";
                break;
            case 'rent':
                $text = "Укажи *адрес*, *район* или *часть города*, в котором тебе хотелось бы *снять* недвижимость."."\n\n".
                        "_Максимально 50 символов_";
                break;
            case 'lease':
                $text = "Укажи *адрес*, *район* или *часть города*, в котором ты *сдаешь* недвижимость."."\n\n".
                        "_Максимально 50 символов_";
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
