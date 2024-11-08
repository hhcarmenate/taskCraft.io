<?php

namespace App\Http\Resources;

use App\Models\StarredUserBoard;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BoardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'workspace_id' => $this->workspace_id,
            'visibility' => $this->visibility,
            'starred' => $this->getStarredStatus()
        ];

    }

    /**
     * Retrieves the starred status of the current board for the authenticated user.
     *
     * @return bool True if the board is starred by the authenticated user, false otherwise.
     */
    private function getStarredStatus(): bool
    {
        $currentBoardUser = StarredUserBoard::query()
            ->where('user_id', Auth::user()->id)
            ->where('board_id', $this->id)
            ->first();

        if (!$currentBoardUser) {
            return false;
        }

        return (bool)$currentBoardUser->is_starred;
    }
}

