<?php

namespace App\Http\Controllers;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('cities');
    }

    public function getInfo(Request $r){
        PersonalAccessToken::where('tokenable_id',$r->user()->id)->delete();
        $user = User::where('email',$r->user()->email)->first();
            // $user = $r->user();
        $t = $user->createToken('asdf')->plainTextToken;
        $user->token = explode("|",$t)[1];

        return $user;

    }
}
