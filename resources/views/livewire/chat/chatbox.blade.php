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
            @forelse($messages as $message)
                @if($loop->first || $message->user_id !== $prevMessageUserId)
                    @if(!$loop->first)
                        </div>
                    </div>
                    @endif

                    <p class="p-4 text-center text-sm text-gray-500">{{ $message->updated_at->format('d.m h:i') }}</p>

                    @if ($message->user_id === auth()->user()->id)
                        <div class="flex flex-row justify-end">
                            <div class="messages text-sm text-white grid grid-flow-row gap-2">
                    @else
                        <div class="flex flex-row justify-start">
                            <div class="w-8 h-8 relative flex flex-shrink-0 mr-4">
                                <img class="shadow-md rounded-full w-full h-full object-cover"
                                     src="https://ui-avatars.com/api/?background=random&name={{ $message->user->name }}"
                                     alt=""
                                />
                            </div>
                            <div class="messages text-sm text-gray-700 grid grid-flow-row gap-2">
                    @endif

                    @php
                        $prevChatUserId = $message->user_id;
                    @endphp
                @endif
                <div class="flex items-center group {{ $message->user->id === auth()->user()->id ? 'flex-row-reverse' : '' }}">
                    <p class="{{ $message->user->id === auth()->user()->id ? 'px-6 py-3 rounded-l-full bg-blue-700 max-w-xs lg:max-w-md' : 'px-6 py-3 rounded-t-full rounded-r-full bg-gray-800 max-w-xs lg:max-w-md text-gray-200' }}">
                        {{ $message->content }}
                    </p>
                </div>
                    @if($loop->last)
                            </div>
                        </div>
                    @endif
            @empty
                <p>Поприветствуйте собеседника!:)</p>
            @endforelse
        </div>
    @else
        <p>Выберите чат</p>
    @endif
        @livewire('chat.send-message')
</section>

