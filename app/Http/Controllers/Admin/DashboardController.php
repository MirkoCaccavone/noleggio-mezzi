<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return $user->email;
        // dd(Auth::user());
        // return "sono nella index dell'amministrazione";
    }

    public function profile()
    {
        return "sono nel profile dell'amministrazione";
    }
}
