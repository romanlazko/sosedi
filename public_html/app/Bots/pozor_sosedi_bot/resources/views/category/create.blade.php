<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex items-center sm:space-x-3 w-max">
            <x-a-buttons.back href="{{ route('admin.telegram_bot.category.index', [$telegram_bot] ) }}"/>
            <x-bot-block :telegram_bot="$telegram_bot"/>
        </div>
        <x-telegram.menu :telegram_bot="$telegram_bot"/>
    </x-slot>

    <div class="w-full space-y-6 m-auto max-w-2xl p-6">
        <x-form.post method="post" action="{{ route('admin.telegram_bot.category.store', $telegram_bot) }}">
            <x-white-block class="space-y-6 p-4">
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Create category') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Use this form to create category.') }}
                    </p>
                    <hr>
                </div>
                
                <div>
                    <x-form.label for="is_active" >
                        <div class="w-full flex items-stretch space-x-2">
                            <div class="flex-col">
                                <input type="hidden" name="is_active" value="0">
                                <x-form.input id="is_active" name="is_active" type="checkbox" class="mt-1 block" value="1"/>
                            </div>
                            <div class="flex-col">
                                {{ __('Is active:') }}
                            </div>
                        </div>
                    </x-form.label>
                    <x-form.error class="mt-2" :messages="$errors->get('is_active')" />
                </div>

                <div>
                    <x-form.label for="icon_name" :value="__('Icon name:')" />
                    <x-form.input id="icon_name" name="icon_name" type="text" class="mt-1 block w-full" :value="old('icon_name')" required autofocus autocomplete="icon_name" />
                    <x-form.error class="mt-2" :messages="$errors->get('icon_name')" />
                </div>
                
                <livewire:translate-category/>
            </x-white-block>

            <div class="flex justify-end">
                <x-buttons.primary>{{ __('Create') }}</x-buttons.primary>
            </div>
        </x-form.post>
    </div>
</x-app-layout>
