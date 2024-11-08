<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreRequest;
use App\Http\Requests\Item\UpdateRequest;
use App\Models\Item;
use App\Models\Type;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(10);
        return view('items.list', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('items.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Item\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        try {
            Item::create($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('items.index')->with('success', 'New data successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $types = Type::all();
        return view('items.edit', compact('item', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Item $item)
    {
        $validated = $request->validated();

        try {
            $item->update($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('items.index')->with('success', 'New data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->errorInfo);
        }
        
        return redirect()->route('items.index')->with('success', 'Selected data successfully deleted');
    }
}
