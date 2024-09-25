<?php

namespace Modules\Note\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Note\Http\Requests\NoteRequest;
use Modules\Note\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())->get();

        return view('notesindex', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('note::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {
        info(auth()->id());
        $data = $request->validated();

        Note::create(['user_id' => auth()->id()] + $data);

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('note::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('note::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteRequest $request, $id)
    {
        $data = $request->validated();
        $note = Note::where(['id'=> $id, 'user_id' => auth()->id()])->firstOrFail();

        $note->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $note = Note::where(['id'=> $id, 'user_id' => auth()->id()])->firstOrFail();

        $note->delete();

        return redirect()->back();
    }
}
