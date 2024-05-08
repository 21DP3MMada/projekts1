<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\StoreNoteRequest; 
use Illuminate\Http\Request;
use Auth; // For accessing the logged-in user

class NoteController extends Controller
{
    public function store(StoreNoteRequest $request)
    {
        // Check if a note already exists for this product and user
        $note = Note::where('product_id', $request->product_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($note && empty($request->note_text)) {
            // Delete the note if it exists and the new text is empty
            $note->delete();
            return response()->json(['message' => 'Note deleted.']);
        } else {
            // Create a new note
            $note = Note::create([
                'note_text' => $request->note_text,
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ]);
        }

        return response()->json(['message' => 'Note saved.', 'note' => $note]);
    }


    public function show($productId)
    {
        $note = Note::where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();

        return response()->json($note);
    }

    public function index()
    {
        $notes = Auth::user()->notes()->orderBy('updated_at', 'desc')->get();
        return view('viewnotes', compact('notes'));
    }


}