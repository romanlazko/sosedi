<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitKauce extends Command
{
    public static $expectation = 'await_kauce';

    public static $pattern = '/^await_kauce$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришлите пожалуйста размер залога в виде текстового сообщения.*");
            return $this->bot->executeCommand(Cost::$command);
        }

        if (iconv_strlen($text) > 12){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(Cost::$command);
        }

        if (!is_numeric($text)){
            $this->handleError("*Залог должен быть указан только цифрами*");
            return $this->bot->executeCommand(Cost::$command);
        }

        $this->getConversation()->update([
            'kauce' => $text,
        ]);

        return $this->bot->executeCommand(Location::$command);
    }
}
