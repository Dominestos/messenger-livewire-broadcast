<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;

class Chatlist extends Component
{
    public $auth_id;
    public $chats;
    public $chatUsers;
    public $receiver;
    protected $listeners = ['selectedChat'];

    public function __construct()
    {
        $this->auth_id = auth()->user()->id;
    }

    public function selectedChat($chat, $receiverId)
    {
        $this->selectedChat = Chat::find($chat['id']);


        $this->dispatch("loadChat", $chat, $receiverId)->to(Chatbox::class);
        $this->dispatch("updateSendMessage", $chat, $receiverId)->to(SendMessage::class);

    }

    public function getChatUserInstance(Chat $chat, $prop)
    {
        foreach ($chat->users as $user) {
            if ($user->id !== $this->auth_id) {
                $this->receiver = User::firstWhere('id', $user->id);
            }
        }

        if (isset($prop)) {
            return $this->receiver->$prop;
        }
    }

    public function mount()
    {
        $this->chats = Chat::whereHas('users', function ($query) {
            $query->where('user_id', $this->auth_id);
        })->orderByDesc('updated_at')->get();
    }
    public function render()
    {
        $this->mount();

        return view('livewire.chat.chatlist');
    }
}
