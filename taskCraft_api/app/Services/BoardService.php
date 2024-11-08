<?php

namespace App\Services;

use App\Models\Board;
use App\Models\StarredUserBoard;
use App\Models\Workspace;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BoardService
{
    /**
     * Getting all my workspaces
     * @param Workspace $workspace
     * @return Collection
     */
    public function getWorkspaceBoards(Workspace $workspace): Collection
    {
        return $workspace->boards;
    }


    /**
     * Create new Board
     * @param Request $request
     * @return Board
     * @throws Exception
     */
    public function createBoard(Request $request): Board
    {
        $board = Board::query()->create([
            'title' => $request->input('title'),
            'workspace_id' => $request->input('workspaceSelected'),
            'visibility' => $request->input('visibility'),
        ]);

        if (!$board) {
            throw new Exception('Board creation fail, please try again later!');
        }

        return $board;
    }

    /**
     * Toggle the "starred" status of a board.
     *
     * @param mixed $board Board object to toggle the starred status for.
     * @return mixed Board object after toggling the starred status.
     */
    public function toggleStarred(Board $board): mixed
    {
        $userId = Auth::user()->id;
        $boardId = $board->id;

        $starredBoardUser = StarredUserBoard::query()
            ->where('user_id', $userId)
            ->where('board_id', $boardId)
            ->first();

        if ($starredBoardUser) {
            $starredBoardUser->is_starred = !$starredBoardUser->is_starred;
            $starredBoardUser->save();
            return $board;
        }

        StarredUserBoard::query()
            ->create([
                'user_id' => $userId,
                'board_id' => $boardId,
                'is_starred' => request()->input('starred')
            ]);

        return $board;
    }

    /**
     * Retrieves the count of starred boards across all workspaces of the logged-in user.
     *
     * @return int The count of starred boards.
     * @throws Exception
     */
    public function getStarredCount(): int
    {
        $userLogged = request()->user();
        if (!$userLogged) {
            throw new Exception('Invalid user logged!');
        }

        return StarredUserBoard::query()
            ->where('user_id', Auth::user()->id)->count() ?? 0;
    }
}
