<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

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
        ;
    }

    public function show()
    {
        $data = product::all();
        return view('product', compact('data'));
    }

    public function download(Request $request, $file)
    {
        return response()->download(public_path('assets/' . $file));
    }

    public function view($id)
    {
        $data = Product::find($id);

        return view('viewproduct', compact('data'));
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

}