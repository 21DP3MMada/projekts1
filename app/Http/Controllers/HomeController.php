<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;

            if ($usertype == 'user') {
                return view('dashboard');
            } else if ($usertype == 'admin') {
                return view('admin.adminhome');
            } else {
                return redirect()->back();
            }
        }
    }

    public function redirectAfterBack()
    {
        $usertype = Auth()->user()->usertype;

        if ($usertype === 'user') {
            return redirect()->route('bookpage');
        } else if ($usertype === 'admin') {
            return redirect()->route('uploadpage');
        } else {
            return redirect()->back();
        }
    }

    public function post()
    {
        return view('post');
    }

    public function uploadpage()
    {
        return view('product');
    }

    public function store(Request $request)
    {
        $data = new product();

        // Validate the incoming file
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240'
        ]);

        $file = $request->file;

        // Generate a unique filename with file hash
        $uniqueFilename = md5_file($file->getRealPath()) . '.' . $file->getClientOriginalExtension();

        // Check if a file with the same content (hash) already exists
        if (Product::where('file', $uniqueFilename)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Book is already uploaded!']);
        }

        // Store the file
        $file->move('assets', $uniqueFilename);

        $data->file = $uniqueFilename;
        $data->title = $request->title;
        $data->author = $request->author;
        $data->category = $request->category;
        $data->save();

        return redirect()->back()->with('success', 'Book uploaded successfully!');

    }

    public function show()
    {
        $data = product::all();

        return view('product', compact('data'));
    }

    public function bookpage()
    {
        $data = product::all();
        return view('allBooks', compact('data'));
    }


    public function download(Request $request, $file)
    {
        return response()->download(public_path('assets/' . $file));
    }

    public function view($id)
    {
        $data = Product::find($id);
        $product = Product::findOrFail($id);
        $reviews = $product->reviews()->latest()->get();

        return view('viewproduct', compact('product', 'reviews', 'data'));
    }

    public function destroy($id)
    {
        $data = Product::find($id);
        if ($data) {
            // Delete file from assets folder
            $filePath = 'assets/' . $data->file;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Delete record from database
            $data->delete();

            return redirect()->back()->with('success', 'Book deleted successfully!');
        } else {
            return redirect()->back()->withErrors(['error' => 'nav labi']);
        }
    }


    public function sendNotification(Request $request)
    {
        $request->validate(['message' => 'required']);

        // Send to all users (adjust if you want specific targeting)
        $users = User::all();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => $request->message
            ]);
        }

        return back()->with('success', 'Notification sent!');
    }



}