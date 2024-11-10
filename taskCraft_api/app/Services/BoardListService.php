<?php

namespace App\Services;

use App\Models\Board;
use App\Models\BoardList;
use Exception;
use Illuminate\Http\Request;

class BoardListService
{
    /**
     * @throws Exception
     */
    public function createBoardList(Request $request, Board $board)
    {
        $boardList = BoardList::query()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description') ?? null,
            'board_id' => $board->id,
            'position' => $this->calculatePosition($board)
        ]);

        if (!$boardList) {
            throw new Exception('Board List creation fail, please try again later!');
        }

        return $boardList;
    }

    /**
     * Calculates the position of a new board item based on the last item in the board list.
     *
     * @param Board $board The board for which the position needs to be calculated.
     *
     * @return int Returns the position value for the new board item.
     */
    private function calculatePosition(Board $board): int
    {
        $lastPost = BoardList::query()
            ->where('board_id', $board->id)
            ->orderBy('position', 'Desc')
            ->first();

        if (!$lastPost) {
            return 1;
        }

        return $lastPost->position + 1;
    }


    /**
     * Updating board positions.
     * @throws Exception
     */
    public function updateBoardListPositions($request, $board): void
    {
        try {
            $positions = $request->input('positions');
            if (count($positions)) {
                foreach($positions as $position) {
                    $list = BoardList::query()
                        ->where('board_id', $board->id)
                        ->where('id', $position['id'])
                        ->first();

                    if ($list) {
                        $list->position = $position['position'];
                        $list->save();
                    }

                }
            }
        } catch (Exception $e) {
            throw new Exception('Oops! Something went wrong'. $e->getMessage());
        }
    }

    /**
     * Update the title of a BoardList object with the new title provided in the request.
     *
     * @param Request $request The request containing the new list title.
     * @param BoardList $boardList The BoardList object to be updated.
     *
     * @return BoardList The updated BoardList object with the new title.
     */
    public function updateListTitle(Request $request, BoardList $boardList): BoardList
    {
        $boardList->title = $request->input('newListTitle');
        $boardList->save();

        $boardList->refresh();

        return $boardList;
    }
}
