<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Attachment;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SendMessage extends Component
{
    use WithFileUploads;

    public $selectedChat;
    public $storedMessage;
    public $content = '';
    public $images = [];
    public $receiver;

    protected $listeners=['updateSendMessage', 'dispatchMessageSent'];

    public function updateSendMessage($chat, $receiverId)
    {
        $this->selectedChat = $chat;
        $this->receiver = User::find($receiverId);
    }

    public function sendMessage()
    {
        $validatedData = $this->validatedData();

        if ($this->content === '' && $this->images === [])
            return null;

        $this->storedMessage = $this->storeMessage();

        $this->dispatch('updateMessageView', $this->storedMessage->id)->to('chat.chatbox');
        $this->dispatch('refresh')->to('chat.chatlist');

        $this->reset('images', 'content');

        $this->dispatch('dispatchMessageSent')->self();
    }

    public function dispatchMessageSent()
    {
        $selectedChat = Chat::find($this->selectedChat['id']);
        broadcast(new MessageSent(auth()->user(), $this->storedMessage, $selectedChat, $this->receiver));
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }

    public function validatedData()
    {
        return $this->validate([
            'content' => 'string|nullable',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|max:4096',
        ]);
    }

    protected function storeMessage()
    {
        try {
            DB::beginTransaction();

            $newMessage = Message::create([
                'content' => $this->content,
                'chat_id' => $this->selectedChat['id'],
                'user_id' => auth()->user()->id,
            ]);

            if (!empty($this->images)) {
                foreach ($this->images as $image) {
                    $image = Storage::disk('public')->put('/images', $image);

                    Attachment::create([
                        'link' => $image,
                        'message_id' => $newMessage->id,
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            abort('500');
        }

        return $newMessage;

    }
}
