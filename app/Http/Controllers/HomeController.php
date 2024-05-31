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


        $request->validate([
            'file' => 'required|file|mimes:pdf|max:10240'
        ]);

        $file = $request->file;


        $uniqueFilename = md5_file($file->getRealPath()) . '.' . $file->getClientOriginalExtension();


        if (Product::where('file', $uniqueFilename)->exists()) {
            return redirect()->back()->withErrors(['error' => 'Book is already uploaded!']);
        }


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

    public function bookpage(Request $request)
    {
        $query = $request->get('query'); // Get search query

        $data = product::query();

        if ($query) {
            $data->where('title', 'like', '%' . $query . '%');
        }

        $data = product::all();
        return view('allBooks', compact('data'));
    }

    // HomeController.php

public function carousel(Request $request)
{
    $data = product::all();

    return view('welcome', compact('data')); 
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

            $data->reviews()->delete();
            $filePath = 'assets/' . $data->file;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }


            $data->delete();

            return redirect()->back()->with('success', 'Book deleted successfully!');
        } else {
            return redirect()->back()->withErrors(['error' => 'nav labi']);
        }
    }


    public function sendNotification(Request $request)
    {
        $request->validate(['message' => 'required']);


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