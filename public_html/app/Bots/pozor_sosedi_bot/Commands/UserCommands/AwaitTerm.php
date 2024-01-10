<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class AwaitTerm extends Command
{
    public static $expectation = 'await_term';

    public static $pattern = '/^await_term$/';

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $text = $updates->getMessage()?->getText();
        $type = $updates->getInlineData()->getType();

        if ($text === null) {
            $this->handleError("*Пришлите пожалуйста срок в виде текстового сообщения.*");
            return $this->bot->executeCommand(Term::$command);
        }

        if (iconv_strlen($text) > 20){
            $this->handleError("*Слишком много символов*");
            return $this->bot->executeCommand(Term::$command);
        }

        $this->getConversation()->update([
            'term' => $text,
        ]);

        if ($type == 'lease' OR $type == 'sell') {
            return $this->bot->executeCommand(Photo::$command);
        }

        return $this->bot->executeCommand(Title::$command);
    }
}
