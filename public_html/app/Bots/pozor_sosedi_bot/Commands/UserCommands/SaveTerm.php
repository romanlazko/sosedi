<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class SaveTerm extends Command
{
    public static $command = 'save_term';

    public static $usage = ['save_term'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $type = $updates->getInlineData()->getType();
        
        $this->getConversation()->update([
            'term' => $updates->getInlineData()->getTerm()
        ]);
            
        if ($type == 'lease' OR $type == 'sell') {
            return $this->bot->executeCommand(Photo::$command);
        }

        return $this->bot->executeCommand(Title::$command);
    }
}
