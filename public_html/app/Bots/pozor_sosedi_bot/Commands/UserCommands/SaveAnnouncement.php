<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use App\Bots\pozor_sosedi_bot\Models\Announcement;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\DB;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class SaveAnnouncement extends Command
{
    public static $command = 'save_announcement';

    public static $usage = ['save_announcement'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        $notes = $this->getConversation()->notes;

        $announcement = Announcement::updateOrCreate([
            'telegram_chat_id'  => DB::getChat($updates->getChat()->getId())->id,
            'title' => $notes['title'] ?? null,
            'caption' => $notes['caption'] ?? null,
            'city' => $notes['city'] ?? null,
            'type' => $notes['type'] ?? null,
            'category' => $notes['category'] ?? null,
            'term' => $notes['term'] ?? null,
            'cost' => $notes['cost'] ?? null,
            'kauce' => $notes['kauce'] ?? null,
            'location' => $notes['location'] ?? null,
        ]);

        if (isset($notes['photos'])) {
            foreach ($notes['photos'] as $photo) {
                $announcement->photos()->create([
                    'file_id' => $photo
                ]);
            }
        }
        
        return $this->bot->executeCommand(Published::$command);
    }
}