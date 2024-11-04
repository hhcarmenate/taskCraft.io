<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Http\Resources\BoardResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\Board;
use App\Services\BoardService;
use Exception;
use Illuminate\Http\JsonResponse;

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
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //
    }
}
