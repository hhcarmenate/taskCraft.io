<?php

namespace App\Services;

use App\Models\Board;
use App\Models\StarredUserBoard;
use App\Models\Workspace;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
     * Update board selected.
     * @param Request $request
     * @param Board $board
     * @return mixed
     */
    public function updateBoard(Request $request, Board $board): Board
    {
        $board->title = $request->input('title');
        $board->workspace_id = $request->input('workspaceSelected');
        $board->visibility = $request->input('visibility');

        $board->save();

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
            ->where('user_id', Auth::user()->id)
            ->where('is_starred', 1)
            ->count() ?? 0;
    }

    /**
     * Saves a recent board for the current user.
     *
     * @param int $boardId The ID of the board to be saved as recent.
     *
     * @throws Exception
     */
    public function saveRecent(int $boardId)
    {
        try {
            $board = Board::query()->find($boardId);
            $user = Auth::user();
            $cacheName = 'recent_boards_' . $user->id;

            $recentBoards = collect(Cache::get($cacheName, []));

            $filteredBoards = $recentBoards->filter(function($recent) use ($board) {
                return $recent['id'] !== $board->id;
            });

            $filteredBoards->unshift($board);
            $updatedRecentBoards = $filteredBoards->slice(0, 5);
            Cache::put($cacheName, $updatedRecentBoards->toArray());

            return $this->getRecent();
        } catch (Exception $e) {
            Log::error('Recent Board cache fail', [$e]);

            throw new Exception('Recent Board cache fail');
        }
    }

    /**
     * Retrieves the recent boards for the current user.
     *
     * This method fetches the recent boards for the currently authenticated user by retrieving the information stored in the cache.
     */
    public function getRecent()
    {
        $user = Auth::user();
        $cacheBoards = Cache::get('recent_boards_' . $user->id, []);

        return collect($cacheBoards)->map(function($boardData) {
            $board = new Board($boardData);
            $board->id = $boardData['id'];
            return $board;
        });
    }

}
