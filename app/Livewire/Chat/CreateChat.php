<?php

namespace App\Livewire\Chat;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;

class CreateChat extends Component
{
    public $users;

    public function checkConversation($receiverId)
    {
        $mainUser = auth()->user();
        $mainUserId = $mainUser->id;
        $chat = Chat::whereHas('users', function ($query) use ($mainUserId, $receiverId) {
            $query->whereIn('users.id', [$mainUserId, $receiverId]);
        }, '=', 2)->get();
//        dd(count($chat));
        if (count($chat) === 0) {
            $newChat = $mainUser->chats()->create([
                'user_creator_id' => $mainUserId,
            ]);
            $newChat->users()->sync([$receiverId, $mainUserId]);
            $newChat->save();

            dd('saved');

        } else {
            dd(count($chat));
        }


    }
    public function render()
    {
        $this->users = User::where('id', '!=', auth()->user()->id)->get();
        return view('livewire.chat.create-chat');
    }
}
