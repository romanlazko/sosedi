<x-header.link :href="route('admin.telegram_bot.category.index', $telegram_bot)" :active="request()->routeIs('admin.telegram_bot.category.*')">
    {{ __('Categories') }}
</x-header.link>

<x-header.link :href="route('admin.telegram_bot.announcement.index', $telegram_bot)" :active="request()->routeIs('admin.telegram_bot.announcement.*')">
    {{ __('Announcement') }}
</x-header.link>