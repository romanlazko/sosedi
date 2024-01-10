<?php

namespace App\Bots\pozor_sosedi_bot;


class Config
{
    public static function getConfig()
    {
        return [
            'inline_data'       => [
                'city'              => null,
                'type'              => null,
                'term'              => null,
                'condition'         => null,
                'category'       => null,
                'announcement_id'   => null,
            ],
            'brno'      => '@sosedi_brno',
            'prague'    => '@sosedi_prague',
            'admin_ids'         => [
            ],
            'bot_username' => 'pozor_sosedi_bot'
        ];
    }
}
