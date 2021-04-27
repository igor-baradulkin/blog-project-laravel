<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PageInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request){
        $this->validate($request, [
           'name' => 'required|max:255',
           'username' => 'required|max:255|unique:users',
           'email' => 'required|email|max:255',
           'password' => 'min:6|required_with:repeat_password',
           'repeat_password' => 'min:6|same:password'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username
        ]);

        PageInfo::create([
            'user_id' => $user->id,
            'profile_image' => 'default_image.png'
        ]);

        auth()->attempt($request->only('email', 'password'));

        return redirect()->route('dashboard');
    }
}
