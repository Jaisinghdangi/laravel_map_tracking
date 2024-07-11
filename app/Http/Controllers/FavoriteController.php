<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Type;
use Illuminate\Support\Facades\View;


use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{

    public function googleAutoAddress()
    {
    	return view('favorites.mapsearch');
    }

    public function googleAutoDirection()
    {

    	return view('favorites.home');
    }
    

    
    public function googleAutotracking()
    {
        $records = DB::table('tracking_record')->get();


       
    	return view('favorites.tracking',['records' => $records]);
    }
    
    public function checkapi()
    {


       
    	return view('favorites.checkAPI');
    }
    
    
    public function homeapi()
    {


       
    	return view('favorites.homeapi');
    }
    public function updateapi()
    {


       
    	return view('favorites.update');
    }

    
    public function index()
    {
        // to get all data
        $favorites = Favorite::all();
        // load view and pass favorites
        
        return View::make('favorites.index')->with(['favorites' => $favorites]);
    }

    // public function index() : View
    // {
    //     return view('products.index', [
    //         'products' => Product::latest()->paginate(3)
    //     ]);
    // }

    public function create()
    {
        $categories = Category::all();
        $types = Type::all();
        return View::make('favorites.create')->with(['categories' => $categories, 'types' => $types]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'required',
            'type' => 'required'
        ]);
        $data = new Favorite;
        $data->name = $request->name;
        $data->link = $request->link;
        $data->type_id = $request->type;
        $data->category_id = $request->category;
        $data->save();
        return redirect()->route('favorites.index')->with('success', 'Favourite has been created successfully.');
    }

    public function show($id)
    {
        $favorite = Favorite::find($id);
        return View::make('favorites.show')->with(['favorite' => $favorite]);
    }

    public function edit($id)
    {
        $favorite = Favorite::find($id);
        $categories = Category::all();
        $types = Type::all();
        return View::make('favorites.edit')
            ->with(['favorite' => $favorite,  'categories' => $categories, 'types' => $types]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'required',
            'type' => 'required',
            'category' => 'required'
        ]);
        $data = Favorite::find($id);
        $data->name = $request->name;
        $data->link = $request->link;
        $data->type_id = $request->type;
        $data->category_id = $request->category;
        $data->save();
        return redirect()->route('favorites.index')
            ->with('success', 'Company Has Been updated successfully');
    }

    public function destroy($id)
    {
        $data = Favorite::find($id);
        $data->delete();
        return redirect()->route('favorites.index')
        ->with('success', 'Favourite has been deleted successfully');
    }

    public function sendCustomResponse()
{
    $data = [
        'message' => 'This is a custom response',
        'status' => 'success'
    ];

    return response()->json($data)
        ->header('Content-Type', 'application/json')
        ->header('X-Custom-Header-One', 'HeaderValue1')
        ->header('X-Custom-Header-Two', 'HeaderValue2');
}

}
