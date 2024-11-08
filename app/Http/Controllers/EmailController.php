<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Http\Requests\Email\StoreRequest;
use App\Http\Requests\Email\UpdateRequest;
use App\Models\Email;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Email::paginate(10);
        return view('emails.list', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('emails.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Email\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        try {
            Email::create($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('emails.index')->with('success', 'New data successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        return view('emails.show', compact('email'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {        
        return view('emails.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Item\UpdateRequest  $request
     * @param  App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Email $email)
    {
        $validated = $request->validated();

        try {
            $email->update($validated);
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        
        return redirect()->route('emails.index')->with('success', 'New data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Email $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        try {
            $email->delete();
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->errorInfo);
        }
        
        return redirect()->route('emails.index')->with('success', 'Selected data successfully deleted');
    }
}
