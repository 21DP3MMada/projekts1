<?php

namespace App\Http\Controllers;

use App\Note; // Replace with your model namespace
use Illuminate\Http\Request;

class NoteController extends Controller
{
  public function index()
  {
    return view('notes');
  }

  public function save(Request $request)
  {
    // Assuming you have a 'user_id' to associate the note with
    $note = Note::updateOrCreate(
      ['user_id' => auth()->id()],
      ['content' => $request->content]
    );

    return response()->json(['success' => true]);
  }

  public function get()
  {
    $note = Note::where('user_id', auth()->id())->first();
    return response()->json(['content' => $note ? $note->content : '']);
  }
}