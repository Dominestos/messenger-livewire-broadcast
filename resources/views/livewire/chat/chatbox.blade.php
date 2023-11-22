<section class="flex flex-col flex-auto border-l border-gray-800">
    @if ($selectedChat)
        <div class="chat-header px-6 py-4 flex flex-row flex-none justify-between items-center shadow">
            <div class="flex">
                <div class="w-12 h-12 mr-4 relative flex flex-shrink-0">
                    <img class="shadow-md rounded-full w-full h-full object-cover"
                         src="https://ui-avatars.com/api/?background=random&name={{ $receiver->name }}"
                         alt=""
                    />
                </div>
                <div class="text-sm">
                    <p class="font-bold">{{ $receiver->name }}</p>
                    <p>Active 1h ago</p>
                </div>
            </div>

            <div class="flex">
                <a href="#" class="block rounded-full hover:bg-gray-700 bg-gray-800 w-10 h-10 p-2 ml-4">
                    <svg viewBox="0 0 20 20" class="w-full h-full fill-current text-blue-500">
                        <path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 Z M9,11 L9,10.5 L9,9 L11,9 L11,15 L9,15 L9,11 Z M9,5 L11,5 L11,7 L9,7 L9,5 Z"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="chat-body p-4 flex-1 overflow-y-scroll">
            @php
                $prevMessageUserId = false;
            @endphp
            @forelse ($messages as $message)
                @if ($loop->first || $message->user_id !== $prevMessageUserId)
                    @if (!$loop->first)
                    </div>
                    </div>
                   @endif

    <p class="p-4 text-center text-sm text-gray-500">{{ $message->updated_at->format('d.m h:i') }}</p>

    <div class="{{ $message->user_id === auth()->user()->id ? 'flex flex-row justify-end' : 'flex flex-row justify-start' }}">
        @if ($message->user_id !== auth()->user()->id)
            <div class="w-8 h-8 relative flex flex-shrink-0 mr-4">
                <img class="shadow-md rounded-full w-full h-full object-cover"
                     src="https://ui-avatars.com/api/?background=random&name={{ $message->user->name }}"
                     alt=""
                />
            </div>
        @endif

        <div class="messages text-sm {{ $message->user_id === auth()->user()->id ? 'text-white' : 'text-gray-700' }} grid grid-flow-row gap-2">
            @endif

            @if ($message->attachments()->exists())
                @foreach ($message->attachments()->get() as $attachment)
                    <div class="flex items-center my-1 {{ $message->user->id === auth()->user()->id ? 'flex-row-reverse' : '' }}">
                        <a class="block w-64 h-64 relative flex flex-shrink-0 max-w-xs lg:max-w-md" href="#">
                            <img class="absolute shadow-md w-full h-full rounded-l-lg object-cover" src="{{ asset('storage/'. $attachment->link) }}" alt="image"/>
                        </a>
                    </div>
                @endforeach
            @endif

            @if (!empty($message->content))
                <div wire:key="{{ $message->id }}" class="flex items-center my-1 {{ $message->user_id === auth()->user()->id ? 'flex-row-reverse' : '' }}">
                    <p class="{{ $message->user_id === auth()->user()->id ? 'px-6 py-3 rounded-l-full bg-blue-700 max-w-xs lg:max-w-md' : 'px-6 py-3 rounded-r-full bg-gray-800 max-w-xs lg:max-w-md text-gray-200' }}">
                        {{ $message->content }}
                    </p>
                </div>
            @endif

            @if ($loop->last)
        </div>
    </div>
    @endif

    @php
        $prevMessageUserId = $message->user_id;
    @endphp

    @empty
        <div class="h-screen flex items-center justify-center">
            <p class="text-center">Поприветствуйте собеседника!!</p>
        </div>
        @endforelse
            </div>
            @else
        <div class="h-screen flex items-center justify-center">
            <p class="text-center">Выберите чат</p>
        </div>
    @endif
    @livewire('chat.send-message')
</section>

