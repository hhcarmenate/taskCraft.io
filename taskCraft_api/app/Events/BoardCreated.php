<?php

namespace App\Events;

use App\Http\Resources\BoardResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BoardCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BoardResource $board;

    /**
     * Create a new event instance.
     */
    public function __construct(Model $board)
    {
        $this->dontBroadcastToCurrentUser();
        $this->board = new BoardResource($board);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('created_board.' . $this->board->workspace_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'board' => $this->board->toArray(request())
        ];
    }
}
