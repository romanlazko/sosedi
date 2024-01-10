<x-nav-link :href="route('admin.telegram_bot.edit', $telegram_bot)" :active="request()->routeIs('admin.telegram_bot.edit')">
    {{ __('WebHook') }}
</x-nav-link>
<x-nav-link :href="route('pozor_sosedi_bot.category.index')" :active="request()->routeIs('pozor_sosedi_bot.category.index')">
    {{ __('Categories') }}
</x-nav-link>