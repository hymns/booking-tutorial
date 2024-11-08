<?php

namespace App\Http\Controllers;

use App\Http\Requests\Type\StoreRequest;
use App\Http\Requests\Type\UpdateRequest;
use Illuminate\Database\QueryException;
use App\Models\Type;


class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::withCount('items')->paginate(10);
        return view('types.list', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Type\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        try {
            Type::create($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('types.index')->with('success', 'New data successfully created');
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
     * @param  App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {        
        return view('types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Type\UpdateRequest  $request
     * @param  App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Type $type)
    {
        $validated = $request->validated();

        try {
            $type->update($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('types.index')->with('success', 'New data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        try {
            $type->delete();
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->errorInfo);
        }
        
        return redirect()->route('types.index')->with('success', 'Selected data successfully deleted');
    }
}
