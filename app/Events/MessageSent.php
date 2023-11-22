<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $chat;
    public $receiver;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Message $message, Chat $chat, User $receiver)
    {
        $this->user = $user;
        $this->message = $message;
        $this->chat = $chat;
        $this->receiver = $receiver;
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->user->id,
            'message' => $this->message->id,
            'chat_id' => $this->chat->id,
            'receiver_id' => $this->receiver->id,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        error_log($this->user);
        error_log($this->receiver);
        return [
            new PrivateChannel('chat.' . $this->receiver->id),
        ];
    }
}
