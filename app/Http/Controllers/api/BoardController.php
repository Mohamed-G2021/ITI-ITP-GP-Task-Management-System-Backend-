<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\Request;
use App\Http\Resources\BoardResource;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Board::all();
        return BoardResource::collection($boards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title"=> "required|min:3",
            "workspace_id"=> 'required'
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }

        $board = Board::create($request->all());
        return (new BoardResource($board))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        return new BoardResource($board);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board)
    {
        $validator = Validator::make($request->all(), [
            "title"=> "required|min:3",
            "workspace_id"=> 'required'
        ]);

        if($validator->fails()){
            dd($validator->errors()->all());
            return response($validator->errors()->all(), 422);
        }


       $board->update($request->all());

        return  new BoardResource($board);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //$board->delete();
        return response('deleted',202);
    }
}
