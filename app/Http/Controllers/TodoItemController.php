<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoItemCollection;
use App\Http\Resources\TodoItemResource;
use App\Models\TodoItem;
use Illuminate\Http\Request;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TodoItemCollection
     */
    public function index()
    {
        return new TodoItemCollection(TodoItem::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TodoItem
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'image|mimes:jpg,png,jpeg',
            'completed' => 'required|string',
        ]);

        if ($request->completed === "true") {
            $request->merge([
                'completed' => true
            ]);
        } else {
            $request->merge([
                'completed' => false
            ]);
        }

        $todo = new TodoItem;
        $todo->title=$request->input('title');
        $todo->description=$request->input('description');
        if ($request->image) $todo->image=$request->file('image')->store('images');
        $todo->completed=$request->input('completed');
        $todo->save();

        return $todo;


//        return TodoItem::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TodoItemResource
     */
    public function show($id)
    {
        return new TodoItemResource(TodoItem::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string',
            'description' => 'string',
            'image' => 'image|mimes:jpg,png,jpeg',
            'completed' => 'string',
        ]);

        if ($request->completed === "true") {
            $request->merge([
                'completed' => true
            ]);
        } else {
            $request->merge([
                'completed' => false
            ]);
        }

        $todo = TodoItem::find($id);
        $todo->title=$request->input('title');
        $todo->description=$request->input('description');
        if ($request->image) $todo->image=$request->file('image')->store('images');
        $todo->completed=$request->input('completed');
        $todo->update();
        return $todo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy($id)
    {
        return TodoItem::destroy($id);
    }
}
