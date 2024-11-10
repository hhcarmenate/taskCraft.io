<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoardListRequest;
use App\Http\Requests\UpdateListPositionRequest;
use App\Http\Requests\UpdateListTitleRequest;
use App\Http\Resources\BoardListResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\Board;
use App\Models\BoardList;
use App\Services\BoardListService;
use Exception;
use Illuminate\Http\JsonResponse;

class BoardListController extends Controller
{
    use FailResponseTrait;

    private BoardListService $boardListService;

    public function __construct(BoardListService $boardListService)
    {
        $this->boardListService = $boardListService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createList(CreateBoardListRequest $request, Board $board): JsonResponse|BoardListResource
    {
        try {
            return BoardListResource::make($this->boardListService->createBoardList($request, $board));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Update the positions of board lists.
     *
     * @param UpdateListPositionRequest $request The request containing the updated list positions
     * @param Board $board The board to update list positions for
     *
     * @return JsonResponse A JSON response indicating the success or failure of updating positions
     */
    public function updatePositions(UpdateListPositionRequest $request, Board $board): JsonResponse
    {
        try {
            $this->boardListService->updateBoardListPositions($request, $board);

            return response()->json(['message' => 'Positions updated successfully']);
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Update the title of a board list.
     *
     * @param UpdateListTitleRequest $request The request containing the new title for the list
     * @param BoardList $boardList The board list to be updated
     *
     * @return JsonResponse|BoardListResource Returns a JSON response or a resource representing the updated board list
     */
    public function updateListTitle(UpdateListTitleRequest $request, BoardList $boardList): JsonResponse | BoardListResource
    {
        try {
            return BoardListResource::make($this->boardListService->updateListTitle($request, $boardList));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }
}
