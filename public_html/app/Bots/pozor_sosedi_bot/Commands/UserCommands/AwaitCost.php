<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitCost extends Command
{
    public static $expectation = 'await_cost';

    public static $pattern = '/^await_cost$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();

        if ($text === null) {
            $this->handleError("*Пришлите пожалуйста стоимость в виде текстового сообщения.*");
            return $this->bot->executeCommand(Cost::$command);
        }

        if (iconv_strlen($text) > 12){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(Cost::$command);
        }

        if (!is_numeric($text)){
            $this->handleError("*Стоимость должна быть указана только цифрами*");
            return $this->bot->executeCommand(Cost::$command);
        }

        $this->getConversation()->update([
            'cost' => $text,
        ]);

        if ($this->getConversation()->notes['type'] == 'lease') {
            return $this->bot->executeCommand(Kauce::$command);
        }

        return $this->bot->executeCommand(Location::$command);
    }
}
