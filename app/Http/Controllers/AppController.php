<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\Models\Karyawan;
use Alert;

class AppController extends Controller
{

	public function index(){
		return view('login');
	}

	public function postLogin(Request $request){

		$info=Karyawan::where('username',$request->username)->first();
    	if(is_null($info)){
    		Alert::error('Maaf, Username atau Password Anda Salah!')->persistent('OK');
    		return redirect()->back();
    	}
    	
		if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $this->cekjatahcuti();
			Alert::success('Login Berhasil');
            return redirect('dashboard');
        }
    	
    	Alert::error('Maaf, Username atau Password Anda Salah!')->persistent('OK');
    	return redirect()->back();
	}

	public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/');
    }

	public function dashboard(){
        $this->cekjatahcuti();
		return view('dashboard');
	}
}
