<div>

    <div class="py-12">
        <div class="max-w-1/2 mx-auto sm:px-6 lg:px-8 ">
            <div class="border-t border-gray-500 overflow-hidden shadow-sm sm:rounded-lg">
                <ol class="list-none list-outside">
                    @foreach($users as $user)
                        <li class="py-2 border-b border-gray-900 text-center" wire:click="checkConversation({{ $user->id }})">{{ $user->name }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
