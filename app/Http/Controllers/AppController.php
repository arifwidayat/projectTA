<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AppController extends Controller
{

	public function index(){
		return view('login');
	}

	public function postLogin(Request $request){
		
	}

	public function dashboard(){
		return view('dashboard');
	}
}
