<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class Chatbox extends Component
{

    protected $listeners = ['loadChat', 'updateMessageView'];
    public $selectedChat;
    public $receiver;
    public $paginateCount = 10;
    public $messageCount;
    public $messages;

    public function loadChat($chat, $receiverId)
    {
        $this->selectedChat = Chat::find($chat['id']);
        $this->receiver = User::find($receiverId);

        $this->messageCount = $this->selectedChat->messages()->count();

        $this->messages = $this->selectedChat->messages()
            ->skip($this->messageCount - $this->paginateCount)
            ->take($this->paginateCount)
            ->get();

        $this->dispatch('chatSelected');
    }

    public function updateMessageView($messageId)
    {
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
    }

    public function render()
    {
        return view('livewire.chat.chatbox');
    }
}
