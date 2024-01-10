<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex items-center sm:space-x-3 w-max">
            <x-bot-block :telegram_bot="$telegram_bot"/>
        </div>
        <x-telegram.menu :telegram_bot="$telegram_bot"/>
    </x-slot>
        {{-- <x-white-block class="p-0">
            <x-search :action="route('pozor_sosedi_bot.announcement.index')"/>
        </x-white-block> --}}

        <x-white-block class="p-0">
            <x-table.table>
                <x-table.thead>
                    <tr>
                        <x-table.th>id</x-table.th>
                        <x-table.th>Chat</x-table.th>
                        <x-table.th>City</x-table.th>
                        <x-table.th>Type</x-table.th>
                        <x-table.th>Announcement</x-table.th>
                        <x-table.th>Cost</x-table.th>
                        <x-table.th>Category</x-table.th>
                        <x-table.th>Condition</x-table.th>
                        <x-table.th>Views</x-table.th>
                        <x-table.th>Status</x-table.th>
                        <x-table.th>
                            <p>Created</p>
                            <p>Updated</p>
                        </x-table.th>
                        <x-table.th></x-table.th>
                    </tr>
                </x-table.thead>
                <x-table.tbody>
                    @forelse ($announcements_collection as $index => $announcement)
                        <tr class="@if($index % 2 === 0) bg-gray-100 @endif text-sm">
                            <x-table.td>{{ $announcement->id }}</x-table.td>
                            <x-table.td class="whitespace-nowrap">
                                @if ($announcement->telegram_chat)
                                    <x-chat-block :chat="$announcement->telegram_chat" :telegram_bot="$telegram_bot"/>
                                @endif
                                
                            </x-table.td>
                            <x-table.td>{{ $announcement->city }}</x-table.td>
                            <x-table.td>{{ $announcement->type }}</x-table.td>
                            <x-table.td>
                                <p><b>{{ $announcement->title }}</b></p>
                                <p>{{ $announcement->caption }}</p>
                            </x-table.td>
                            <x-table.td>{{ $announcement->cost }}</x-table.td>
                            <x-table.td>{{ $announcement->category()->first()?->name }}</x-table.td>
                            <x-table.td>{{ $announcement->condition }}</x-table.td>
                            <x-table.td>{{ $announcement->views }}</x-table.td>
                            <x-table.td>{{ $announcement->status }}</x-table.td>
                            <x-table.td class="whitespace-nowrap">
                                <p>{{ $announcement->created_at->diffForHumans() }}</p>
                                <p>{{ $announcement->updated_at->diffForHumans() }}</p>
                            </x-table.td>

                            <x-table.buttons>
                                {{-- <x-a-buttons.secondary href="{{ route('pozor_sosedi_bot.announcement.show', $announcement) }}">Test</x-a-buttons.secondary>
                                @if ($announcement->status === 'new')
                                    <x-a-buttons.primary href="{{ route('pozor_sosedi_bot.announcement.edit', $announcement) }}">Edit</x-a-buttons.primary>
                                @endif
                                <form action="{{ route('pozor_sosedi_bot.announcement.destroy', $announcement) }}" method="post" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <x-buttons.danger>Delete</x-buttons.dangertton>
                                </form> --}}
                            </x-table.buttons>
                        </tr>
                    @empty
                    @endforelse
                </x-table.tbody>
            </x-table.table>
        </x-white-block>
        <div class="mx-3">
            {{ $announcements->withQueryString()->links() }}
        </div>
</x-app-layout>