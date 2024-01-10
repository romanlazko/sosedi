<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex items-center sm:space-x-3 w-max">
            <x-bot-block :telegram_bot="$telegram_bot"/>
        </div>
        <x-telegram.menu :telegram_bot="$telegram_bot"/>
    </x-slot>

    <div class="py-4 sm:p-4 space-y-6">
        <x-white-block class="p-0">
            <x-table.table class="whitespace-nowrap">
                <x-table.thead>
                    <tr>
                        <x-table.th>id</x-table.th>
                        <x-table.th>Name</x-table.th>
                        <x-table.th>Subcategories</x-table.th>
                        <x-table.th>Status</x-table.th>
                        <x-table.th></x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($categories as $index => $category)
                        <tr class="@if($index % 2 === 0) bg-gray-100 @endif">
                            <x-table.td>
                                {{ $category->id }}
                            </x-table.td>

                            <x-table.td>
                                <i class="fa-solid {{ $category->icon_name }}"></i> 
                                <span title="@foreach ($category->translations as $language => $translation) {{ $translation }} @endforeach">
                                    {{ $category->name }}
                                </span>
                            </x-table.td>

                            <x-table.td>
                                <div class="p-1">
                                    @forelse ($category->subcategories as $subcategory_index => $subcategory)
                                        <a href="{{ route('admin.telegram_bot.category.subcategory.edit', [$telegram_bot, $category, $subcategory]) }}">
                                            <x-badge :color="$subcategory->is_active ? 'green' : 'red'">
                                                <i class="fa-solid {{ $subcategory->icon_name }}"></i>
                                                {{ $subcategory->name }}
                                            </x-badge>
                                        </a>
                                        
                                        @if ($subcategory_index % 5 === 4) 
                                            <br>
                                        @endif
                                    @empty
                                        
                                    @endforelse
                                </div>
                            </x-table.td>

                            <x-table.td>
                                <x-badge :color="$category->is_active ? 'green' : 'red'">
                                    {{ $category->is_active ? 'active' : 'disabled' }}
                                </x-badge>
                            </x-table.td>
                            
                            <x-table.buttons>
                                <x-a-buttons.secondary href="{{ route('admin.telegram_bot.category.subcategory.create', [$telegram_bot, $category]) }}">Add subcategory</x-a-buttons.secondary>
                                <x-a-buttons.primary href="{{ route('admin.telegram_bot.category.edit', [$telegram_bot, $category]) }}">Edit</x-a-buttons.primary>
                                <form action="{{ route('admin.telegram_bot.category.destroy', [$telegram_bot, $category]) }}" method="post" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <x-buttons.danger onclick="return confirm('Sure?')">Delete</x-buttons.dangertton>
                                </form>
                            </x-table.buttons>
                        </tr>
                    @empty
                    @endforelse
                </x-table.tbody>
            </x-table.table>
        </x-white-block>
        <div class="w-full items-center justify-center">
            <a href="{{ route('admin.telegram_bot.category.create', $telegram_bot) }}" class="block m-auto w-min whitespace-nowrap text-xl text-gray-500 hover:bg-indigo-700 hover:text-white p-3 rounded-lg">
                <i class="fa-solid fa-circle-plus"></i>
                Create category
            </a>
        </div>
    </div>
</x-app-layout>