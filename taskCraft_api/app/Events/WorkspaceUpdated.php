<?php

namespace App\Events;

use App\Http\Resources\WorkspaceResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorkspaceUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public WorkspaceResource $workspace;

    /**
     * Create a new event instance.
     */
    public function __construct(Model $workspace)
    {
        $this->workspace = new WorkspaceResource($workspace);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('workspace.' . $this->workspace->id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'workspace' => $this->workspace->toArray(request())
        ];
    }
}
