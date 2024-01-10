<?php
namespace App\Bots\pozor_sosedi_bot\Commands;

use Romanlazko\Telegram\App\Commands\CommandsList as DefaultCommandsList;

class CommandsList extends DefaultCommandsList
{
    static private $commands = [
        'admin'     => [
            AdminCommands\StartCommand::class,
            AdminCommands\MenuCommand::class,
            AdminCommands\ShowAnnouncement::class,
            AdminCommands\PublicAnnouncement::class,
            UserCommands\GetOwnerContact::class,
            AdminCommands\RejectAnnouncement::class,
            AdminCommands\ConfirmReject::class,
        ],
        'user'      => [
            UserCommands\StartCommand::class,
            UserCommands\MenuCommand::class,
            
            UserCommands\NewAnnouncement::class,
            UserCommands\AnnouncementType::class,
            UserCommands\Category::class,
            UserCommands\SaveCategory::class,
            UserCommands\Term::class,
            UserCommands\AwaitTerm::class,
            UserCommands\SaveTerm::class,
            UserCommands\Photo::class,
            UserCommands\AwaitPhoto::class,
            UserCommands\Title::class,
            UserCommands\AwaitTitle::class,
            UserCommands\Cost::class,
            UserCommands\AwaitCost::class,
            UserCommands\Kauce::class,
            UserCommands\AwaitKauce::class,
            UserCommands\Location::class,
            UserCommands\AwaitLocation::class,
            UserCommands\Caption::class,
            UserCommands\AwaitCaption::class,
            UserCommands\ShowAnnouncement::class,
            UserCommands\PublicAnnouncement::class,
            UserCommands\SaveAnnouncement::class,
            UserCommands\Published::class,

            UserCommands\RullesCommand::class,
            UserCommands\MyAnnouncements::class,
            UserCommands\ShowMyAnnouncement::class,
            UserCommands\IrrelevantAnnouncement::class,
            UserCommands\SoldAnnouncement::class,
            UserCommands\GetOwnerContact::class,
        ],
        'supergroup' => [
        ],
        'default'   => [
        ],
        
    ];

    static public function getCommandsList(?string $auth)
    {
        return array_merge(
            (self::$commands[$auth] ?? []), 
            (self::$default_commands[$auth] ?? [])
        ) 
        ?? self::getCommandsList('default');
    }

    static public function getAllCommandsList()
    {
        foreach (self::$commands as $auth => $commands) {
            $commands_list[$auth] = self::getCommandsList($auth);
        }
        return $commands_list;
    }
}
