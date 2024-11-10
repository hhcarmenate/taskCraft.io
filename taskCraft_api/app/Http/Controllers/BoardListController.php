<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBoardListRequest;
use App\Http\Resources\BoardListResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\Board;
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

}
