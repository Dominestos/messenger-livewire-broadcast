<?php

namespace App\Livewire\Chat;

use App\Models\Attachment;
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
    public $content = '';
    public $images = [];

    protected $listeners=['updateSendMessage'];

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

        $this->storeData();
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

    protected function storeData()
    {
        try {
            DB::beginTransaction();

            $messageData = Message::create([
                'content' => $this->content,
                'chat_id' => $this->selectedChat['id'],
                'user_id' => auth()->user()->id,
            ]);

            if (!empty($this->images)) {
                foreach ($this->images as $image) {
                    $image = Storage::disk('public')->put('/images', $image);

                    Attachment::create([
                        'link' => $image,
                        'message_id' => $messageData->id,
                    ]);
                }
            }

            $this->reset('images', 'content');
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            abort('500');
        }

    }
}
