<?php

namespace App\Bots\pozor_sosedi_bot\Http\DataTransferObjects;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Romanlazko\Telegram\App\Config;
use App\Bots\pozor_sosedi_bot\Models\BaraholkaCategory;
use App\Bots\pozor_sosedi_bot\Models\BaraholkaSubcategory;

class Announcement
{
    public function __construct(
        public ?int $id = null,
        public ?int $user_id = null,
        public ?int $telegram_chat_id = null,
        public ?string $city = null,
        public ?string $type = null,
        public ?string $title = null,
        public ?string $caption = null,
        public ?int $cost = null,
        public ?string $category = null,
        public ?int $category_id = null,
        public ?int $subcategory_id = null,
        public ?string $condition = null,
        public ?int $views = null,
        public ?string $status = null,
        public Collection|array|null $photos = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    )
    {

    }

    public static function fromRequest(Request $request)
    {
        return new self(
            user_id: $request->user()->id ?? null,
            city: $request->city ?? null,
            type: $request->type ?? null,
            title: $request->title ?? null,
            caption: $request->caption ?? null,
            cost: $request->cost ?? null,
            category_id: $request->category_id ?? null,
            subcategory_id: $request->subcategory_id ?? null,
            condition: $request->condition ?? null,
            photos: $request->photos ?? null,
        );
    }

    public static function fromObject(object $data): Announcement
    {
        return new self(
            telegram_chat_id: $data->chat_id ?? null,
            city: $data->city ?? null,
            type: $data->type ?? null,
            title: $data->title ?? null,
            caption: $data->caption ?? null,
            cost: $data->cost ?? null,
            category_id: $data->category ?? null,
            subcategory_id: $data->term ?? null,
            photos: $data->photos ?? null,
        );
    }
    
    public function prepare(): string
    {
        $text = [];

        if ($this->type) {
            $text[] = $this->type === 'buy' ? '#куплю' : '#продам';
        }

        if ($this->title) {
            $text[] = "<b>{$this->title}</b>";
        }

        if ($this->caption) {
            $text[] = $this->caption;
        }

        if ($this->condition) {
            $text[] = "<i>Состояние:</i> " . ($this->condition === 'new' ? 'Новое' : 'Б/у');
        }

        if ($this->cost) {
            $text[] = "<i>Стоимость:</i> {$this->cost} CZK";
        }

        if ($this->id) {
            $text[] = "<a href='https://t.me/". Config::get('bot_username') ."?start=announcement={$this->id}'>🔗Контакт</a> (<i>Перейди по ссылке и нажми <b>Начать</b></i>)";
        }

        if ($this->category_id) {
            $categories = "#".str_replace(' ', '_', mb_strtolower(BaraholkaCategory::find($this->category_id)->name));

            if ($this->subcategory_id) {
                $categories .= " #".str_replace(' ', '_', mb_strtolower(BaraholkaSubcategory::find($this->subcategory_id)->name));
            }

            $text[] = $categories;
        }

        return implode("\n\n", $text);
    }
}
