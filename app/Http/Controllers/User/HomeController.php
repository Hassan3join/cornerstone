<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $dynamicForms = Form::with(['items'])->get();
        return view('user.home', compact('dynamicForms'));
    }
    public function privacy()
    {
        return view('user.privacy');
    }
    public function terms()
    {
        return view('user.terms');
    }
}
