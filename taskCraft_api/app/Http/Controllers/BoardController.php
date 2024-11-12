<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveRecentBoardRequest;
use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Resources\BoardResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\Board;
use App\Services\BoardService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BoardController extends Controller
{
    use FailResponseTrait;

    private BoardService $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
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
    public function store(StoreBoardRequest $request): JsonResponse|BoardResource
    {
        try {
            return BoardResource::make($this->boardService->createBoard($request));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Toggle board starred
     * @param Board $board
     * @return JsonResponse|BoardResource
     */
    public function toggleStarred(Request $request, Board $board): JsonResponse|BoardResource
    {
        try {
            if ($request->input('starred')) {
                $starredCount = $this->boardService->getStarredCount();

                if ($starredCount >= 5 ) {
                    return response()->json(['message' => 'Starred Limit reached'], 422);
                }
            }

            return BoardResource::make($this->boardService->toggleStarred($board));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Save the board specified in the request as a recent board.
     *
     * @param SaveRecentBoardRequest $request The request containing the board ID to be saved as recent.
     *
     * @return BoardResource|JsonResponse The resource representing the saved recent board.
     */
    public function saveRecentBoard(SaveRecentBoardRequest $request): BoardResource | AnonymousResourceCollection
    {
        try {
            return BoardResource::collection($this->boardService->saveRecent($request->input('boardId')));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * Get the most recent boards.
     *
     * @return JsonResponse|AnonymousResourceCollection A JSON response containing a collection of recent boards. If an exception occurs, a generic fail response is returned.
     */
    public function getRecentBoards(): JsonResponse|AnonymousResourceCollection
    {
        try {
            return BoardResource::collection($this->boardService->getRecent());
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

}
