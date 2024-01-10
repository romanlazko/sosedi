<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitLocation extends Command
{
    public static $expectation = 'await_location';

    public static $pattern = '/^await_location$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришлите пожалуйста локацию в виде текста.*");
            return $this->bot->executeCommand(Location::$command);
        }

        if (iconv_strlen($text) > 50){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(Location::$command);
        }

        $this->getConversation()->update([
            'location' => $text
        ]);
        
        return $this->bot->executeCommand(Caption::$command);
    }
}
