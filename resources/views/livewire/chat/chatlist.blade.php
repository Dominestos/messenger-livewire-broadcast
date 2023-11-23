<section class="flex flex-col flex-none overflow-auto w-24 group lg:max-w-sm md:w-2/5 transition-all duration-300 ease-in-out">
    <div class="header p-4 flex flex-row justify-between items-center flex-none">
        <div class="w-16 h-16 relative flex flex-shrink-0">
            <img class="rounded-full w-full h-full object-cover" alt="ravisankarchinnam"
                 src="https://ui-avatars.com/api/?background=random&name={{ auth()->user()->name }}"/>
        </div>
        <p class="text-md font-bold hidden md:block group-hover:block">{{ auth()->user()->name }}</p>
        <a href="#" class="block rounded-full hover:bg-gray-500 bg-gray-400 w-10 h-10 p-2 hidden md:block group-hover:block">
            <svg viewBox="0 0 24 24" class="w-full h-full fill-current">
                <path
                    d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/>
            </svg>
        </a>
    </div>
    @livewire('chat.message-search')
    <div class="contacts p-2 flex-1 overflow-y-scroll">
        @if(count($chats) > 0)
            @foreach($chats as $key => $chat)
                <div wire:key="{{ $chat->id }}" class="flex justify-between items-center p-3 hover:bg-gray-700 rounded-lg relative" wire:click="$dispatch('selectedChat', [ {{ $chat }}, {{ $this->getChatUserInstance($chat, 'id') }} ])">
                    <div class="w-16 h-16 relative flex flex-shrink-0">
                        <img class="shadow-md rounded-full w-full h-full object-cover"
                             src="https://ui-avatars.com/api/?background=random&name={{ $this->getChatUserInstance($chat, 'name') }}"
                             alt="usr"
                        />
                    </div>
                    <div class="flex-auto min-w-0 ml-4 mr-6 hidden md:block group-hover:block">
                        <p>{{ $this->getChatUserInstance($chat, 'name') }}</p>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="min-w-0">
                                <p class="truncate">{{ (!empty($chat->messages()->latest()->first())) ? $chat->messages()->latest()->first()->content : 'пусто' }}</p>
                            </div>
                            <p class="ml-2 whitespace-no-wrap">{{ $chat->updated_at->format('H:i') }}</p>
                        </div>
                    </div>
                    <div class="bg-blue-700 w-3 h-3 rounded-full flex flex-shrink-0 hidden md:block group-hover:block"></div>
                </div>
            @endforeach
        @else
            <div class="flex justify-between items-center p-3 rounded-lg relative">
                У вас нет созданных бесед
            </div>
        @endif
    </div>
</section>
