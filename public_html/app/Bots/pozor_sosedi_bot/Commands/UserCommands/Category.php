<?php 

namespace App\Bots\pozor_sosedi_bot\Commands\UserCommands;

use App\Bots\pozor_sosedi_bot\Models\BaraholkaCategory;
use Romanlazko\Telegram\App\BotApi;
use Romanlazko\Telegram\App\Commands\Command;
use Romanlazko\Telegram\App\Entities\Response;
use Romanlazko\Telegram\App\Entities\Update;

class Category extends Command
{
    public static $command = 'category';

    public static $title = '';

    public static $usage = ['category'];

    protected $enabled = true;

    public function execute(Update $updates): Response
    {
        switch ($updates->getInlineData()->getType()) {
            case 'buy':
                $buttons = BotApi::inlineCheckbox([
                    [
                        array('Дом', Category::$command, 'h'),
                        array('Квартиру', Category::$command, 'f')
                    ],
                    [array("Продолжить", SaveCategory::$command, '')],
                    [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
                ], 'category');
    
                $text = "Выбери, какой *тип* недвижимости ты хочешь *купить* и нажми «Продолжить».";
    
                break;
            case 'sell':
                $buttons = BotApi::inlineKeyboard([
                    [
                        array('Дом', SaveCategory::$command, 'h'),
                        array('Квартиру', SaveCategory::$command, 'f')
                    ],
                    [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
                ], 'category');

                $text = "Выбери, какой *тип* недвижимости ты хочешь *продать*.";
    
                break;
            case 'rent':
                $buttons = BotApi::inlineCheckbox([
                    [
                        array('Дом', Category::$command, 'h'),
                        array('Квартиру', Category::$command, 'f')
                    ],
                    [
                        array('Комнату', Category::$command, 'r'),
                        array('Место в комнате', Category::$command, 's')
                    ],
                    [array("Продолжить", SaveCategory::$command, '')],
                    [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
                ], 'category');
    
                $text = "Выбери, какой *тип* недвижимости ты хочешь *снять* и нажми «Продолжить».";

                break;
            case 'lease':
                $buttons = BotApi::inlineKeyboard([
                    [
                        array('Дом', SaveCategory::$command, 'h'),
                        array('Квартиру', SaveCategory::$command, 'f')
                    ],
                    [
                        array('Комнату', SaveCategory::$command, 'r'),
                        array('Место в комнате', SaveCategory::$command, 's')
                    ],
                    [array(MenuCommand::getTitle('ru'), MenuCommand::$command, '')]
                ], 'category');
    
                $text = "Выбери, какой тип недвижимости ты хочешь *сдать*."; 

                break;
        }

        $data = [
            'text'          => $text,
            'chat_id'       => $updates->getChat()->getId(),
            'message_id'    => $updates->getCallbackQuery()?->getMessage()?->getMessageId(),
            'parse_mode'    => "Markdown",
            'reply_markup'  => $buttons
        ];

        return BotApi::returnInline($data);
    }
}
