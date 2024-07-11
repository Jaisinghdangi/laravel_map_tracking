<?php



namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Type;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Http\Middleware\AlreadyLoggedIn;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;


class AuthenController extends Controller
{
    public function ragister()
    {
    	return view('auth.registration');
    }
    public function registerUser(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|min:8|max:12'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $result = $user->save();
        if($result){
            return redirect()->route('auth.login')->with('success','You have registered successfully. Now Login HERE!');
        } else {
            return back()->with('fail','Something wrong!')->withInput();
        }
    }


    // public function registerUser(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|min:8|confirmed',
    //     ]);

    //     if ($validator->fails()) {
    //         return back()->withErrors($validator)->withInput();
    //     }
    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = $request->password;

    //     $result = $user->save();
    //     if($result){
    //         return redirect()->route('auth.login')->with('success','You have registered successfully. Now Login HERE!')->withInput();
    //     } else {
    //         return back()->with('fail','Something wrong!')->withInput();
    //     }
    // }

    public function login()
    {
    	return view('auth.login');
    }
 public function loginUser(Request $request)
    {
        $request->validate([            
            'email'=>'required|email:users',
            'password'=>'required|min:8|max:12'
        ]);

        $user = User::where('email','=',$request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $request->session()->put('loginId', $user->id);
                return redirect('favorites')->with('success','You have Login successfully');
            } else {
                return back()->with('fail','Password not match!');
            }
        } else {
            return back()->with('fail','This email is not register.');
        }        
    }




    
    // public function logout()
    public function logout(Request $request)
    {
        $data = array();
        if(Session::has('loginId')){
            Session::pull('loginId');
            $request->user()->tokens()->delete();

            // return redirect('login');
            return redirect()->route('auth.login')->with('success','You are Logged out. Plz Login Again!');

        }
    }

    // public function logout(Request $request)
    // {
    //     $request->user()->tokens()->delete();

    //     return response()->json(['message' => 'Logged out successfully'], 200);
    // }
    // //
}
