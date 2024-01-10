<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create bot:') }}
        </h2>
        <div class="space-x-4 sm:-my-px sm:ml-10 flex py-6">
            <x-nav-link :href="route('admin.telegram_bot.index')">
                {{ __('←') }}
            </x-nav-link>
        </div>
    </x-slot>
    <div class="w-full space-y-6 m-auto max-w-2xl">
        <form method="post" action="{{ route('admin.telegram_bot.store') }}" class="space-y-6">
            @csrf
            <x-white-block>
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('WebHook setup') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Use this form to specify a URL and receive incoming updates via an outgoing webhook.') }}
                    </p>
                    <hr>
                    <div>
                        <x-form.label for="url" :value="__('Url:')" />
                        <x-form.input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('url')" required autocomplete="url" />
                        <x-form.error class="mt-2" :messages="$errors->get('url')"/>
                    </div>
                    <div>
                        <x-form.label for="token" :value="__('Token:')" />
                        <x-form.input id="token" name="token" type="password" class="mt-1 block w-full" :value="old('token')" required autocomplete="token" />
                        <x-form.error class="mt-2" :messages="$errors->get('token')" />
                    </div>
                </div>
            </x-white-block>
            
            <div class="flex justify-end">
                <x-buttons.primary>{{ __('Create') }}</x-buttons.primary>
            </div>
        </form>
    </div>
</x-app-layout>