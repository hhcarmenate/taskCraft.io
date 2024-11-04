<?php

namespace App\Services;

use App\Models\Board;
use App\Models\Workspace;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

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
}
