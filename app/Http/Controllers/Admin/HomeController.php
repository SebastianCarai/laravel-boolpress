<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserInfo;

class HomeController extends Controller
{
    public function index(){
        $user = Auth::user();

        $data = [
            'user' => $user,
            'userInfo' => $user->userInfo
        ];

        return view('admin.home', $data);
    }
}
