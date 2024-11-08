<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::withCount('bookings')->paginate(10);

        return view('users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\User\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make('temp1234');

        try {
            User::create($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('users.index')->with('success', 'New data successfully created');
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
     * @param  App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {        
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\User\UpdateRequest  $request
     * @param  App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $validated = $request->validated();

        if (array_key_exists('password', $validated)) {
            $validated['password'] = Hash::make($validated['password']);
        }

        try {
            $user->update($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('users.index')->with('success', 'New data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->errorInfo);
        }
        
        return redirect()->route('users.index')->with('success', 'Selected data successfully deleted');
    }
}
