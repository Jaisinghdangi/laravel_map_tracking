<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:sanctum');
    // }
    public function index()
    {
        $records = DB::table('tracking_record')->get();
        return response()->json($records, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'color' => 'required|string',
            'image' => 'required|string',
        ]);

        DB::table('tracking_record')->insert([
            'username' =>  $request->username, // Adjust according to your auth setup
            'lat' => $request->lat,
            'lng' => $request->lng,
            'date' => $request->date,
            'color' => $request->color,
            'image' => $request->image,
           // 'created_at' => now(),
           // 'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Record added successfully'], 201);
    }

    public function show($id)
    {
        $record = DB::table('tracking_record')->where('id', $id)->first();
        
        if (!$record) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // DB::table('tracking_record')->insert([
        //     'username' => auth()->user()->name,
        //     'lat' => request()->lat,
        //     'lng' => request()->lng,
        //     'color' => request()->color,
        //     'image' => request()->image,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        return response()->json($record, 200);
    }

    public function update(Request $request, $id)
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $request->validate([
            'lat' => 'sometimes|required|numeric',
            'lng' => 'sometimes|required|numeric',
            'color' => 'sometimes|required|string',
            'image' => 'sometimes|required|string',
        ]);


       
        $updated = DB::table('tracking_record')
            ->where('id', $id)
            ->update([
                'username' =>  $request->username, // Adjust according to your auth setup
                'lat' => $request->lat,
                'lng' => $request->lng,
                'date' => $request->date,
                'color' => $request->color,
                'image' => $request->image,
               // 'updated_at' => now(),
            ]);

        if (!$updated) {
            return response()->json(['message' => 'Record not found or not updated'], 404);
        }
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Record updated successfully'], 200);
    }

    public function destroy($id)
    {
        $deleted = DB::table('tracking_record')->where('id', $id)->delete();

        if (!$deleted) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        $request->session()->put('loginId', $user->id);


        return response()->json(['token' => $token, 'token_type' => 'Bearer'], 200);
    }

    public function logout(Request $request)
    {
        // Ensure the user is authenticated
        if ($request->user()) {
            // Delete all tokens for the user
            $request->user()->tokens()->delete();
        }

        // Clear session login ID
        if (Session::has('loginId')) {
           Session::pull('loginId');
        }

        // Redirect to the login page with a success message
        // return redirect()->route('auth.login')->with('success', 'You are logged out. Please log in again!');
        return response()->json(['msg' => 'You are logged out. Please log in again!'], 200);

    }

}
