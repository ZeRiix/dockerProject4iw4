<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json(Todo::all(), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Todos not found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);
            $todo = new Todo();
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();
            return response()->json(['message' => 'Todo created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Todo creation failed', 
                    'error' => $e->getMessage()
                ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id // todo id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            return response()->json(Todo::find($id), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Todo not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param int  $id // todo id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
            ]);
            $todo = Todo::find($id);
            $todo->title = $request->title;
            $todo->description = $request->description;
            $todo->save();
            return response()->json(['message' => 'Todo updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Todo update failed'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id // todo id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            Todo::destroy($id);
            return response()->json(['message' => 'Todo deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Todo deletion failed'], 500);
        }
    }
}