<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Photo extends Command
{
    public static $command = 'photo';

    public static $title = '';

    public static $usage = ['photo'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $conversation   = $this->getConversation();
        $conversation->unsetNote('photo');

        $updates->getFrom()->setExpectation(AwaitPhoto::$expectation);

        $buttons = BotApi::inlineKeyboard([
            [array('Без фотографий', Title::$command, '')],
            [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
        ]);

        $data = [
            'text'          =>  "Пришли мне *фотографии* надвижимости, *максимально 9 фото*."."\n\n".
                                "_Если фотографий нет, нажми_ *'Без фотографий'*.",
            'reply_markup'  =>  $buttons,
            'chat_id'       =>  $updates->getChat()->getId(),
            'message_id'    =>  $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    =>  "Markdown"
        ];     
                        
        return BotApi::returnInline($data);
    }
}
