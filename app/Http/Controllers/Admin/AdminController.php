<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Show;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    public function index()
    {
        $users = User::all();
        $user_count = $users->count();
        $admin_count = $users->where('role', 5)->count();

        $shows = Show::all();
        $show_count = $shows->count();
        $popular_count = $shows->where('popular', 1)->count();

        $settings = Settings::all();
        $canRegister = $settings->where('name', 'canRegister')->pluck('value');
        $canRegister = $canRegister[0] == 1 ? 'Yes' : 'No';
        $fbUrl = $settings->where('name', 'fbUrl')->pluck('value')[0];
        
        return view('admin.home', compact([
            'user_count', 
            'admin_count', 
            'show_count', 
            'popular_count',
            'canRegister',
            'fbUrl'
        ]));
    }
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact(['users']));
    }
    public function shows()
    {
        $shows = Show::all();
        return view('admin.shows', compact(['shows']));
    }
}
