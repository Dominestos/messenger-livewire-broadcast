<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;

class MessageSearch extends Component
{
    public $searchValue;

    public function handleSubmit()
    {
        $validated = $this->validatedQuery();

        $result = $this->findMessages($validated);

        $this->dispatch('getSearchResult', $result)->to('chat.chatlist');

    }

    public function findMessages($validated)
    {
        return Message::query()
            ->where('content', 'like', "%{$validated['searchValue']}%")
            ->get();
    }
    public function validatedQuery()
    {
        return $this->validate([
            'searchValue' => 'string|required',
        ]);
    }

    public function render()
    {
        return view('livewire.chat.message-search');
    }
}
