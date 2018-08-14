<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Http\Requests;

use App\Models\Karyawan;
use Storage;
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

    public function profile(FormBuilder $formBuilder){
        $data = auth()->user();
        unset($data['password']);

        $form = $formBuilder->create(\App\Forms\Karyawan::class, [
            'method' => 'POST',
            'url' => 'profile',
            'model'=>$data
        ]);
        $title= 'Profile';
        return view('masterdata.form',compact('form','title'));
    }

    public function updateProfile(Request $request)
    {
        $id = auth()->user()->id;
         $validate = $this->validate($request,[
            'id'=>'required|unique:karyawan,id,'.$id,
            'username'=>'required|unique:karyawan,username,'.$id,
            'profil_pic'=>'max:2000|image|mimes:jpg,png,jpeg,gif'
        ]);

        if($request->hasFile('profil_pic')){
            $image      = $request->file('profil_pic');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public_upload')->put($fileName,file_get_contents($image));
            $request['photo'] = 'img/'.$fileName;
        }else{
            $request['photo'] = asset('img/default-user.png');
        }

        if($request->tanggal_lahir){
            $request['tanggal_lahir']=date('Y-m-d',strtotime($request->tanggal_lahir));
        }
        if($request->tanggal_masuk){
            $request['tanggal_masuk']=date('Y-m-d',strtotime($request->tanggal_masuk));
        }
        if($request->password){
            $request['password']=bcrypt($request->password);
        }else{
            unset($request['password']);
        }

        Karyawan::find($id)->update($request->except(['_token','profil_pic']));
        Alert::success('Data Berhasil Diubah');
        return redirect('master/karyawan');
    }
}
