<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DataTables\KaryawanDataTable;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Karyawan;
use Alert;
use Storage;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KaryawanDataTable $karyawan)
    {
        $title= 'Data Master Karyawan';
        $link = route('master.karyawan.create');
        return $karyawan->render('masterdata.index',compact('title','link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\Karyawan::class, [
            'method' => 'POST',
            'route' => 'master.karyawan.store'
        ]);
        $title= 'Tambah Data Karyawan';
        return view('masterdata.form',compact('form','title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request,[
            'id'=>'required|unique:karyawan,id',
            'username'=>'required|unique:karyawan,username',
            'password'=>'required',
            'profil_pic'=>'max:2000|image|mimes:jpg,png,jpeg,gif'
        ]);

        if($request->hasFile('profil_pic')){
            $image      = $request->file('profil_pic');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public_upload')->put($fileName,file_get_contents($image));
            $request['photo']='img/'.$fileName;
        }else{
            $request['photo']=asset('img/default-user.png');
        }

        if($request->tanggal_lahir){
            $request['tanggal_lahir']=date('Y-m-d',strtotime($request->tanggal_lahir));
        }
        if($request->tanggal_masuk){
            $request['tanggal_masuk']=date('Y-m-d',strtotime($request->tanggal_masuk));
        }
        if($request->password){
            $request['password']=bcrypt($request->password);
        }

        Karyawan::create($request->except(['_token','profil_pic']));
        Alert::success('Data Berhasil Ditambahkan');
        return redirect('master/karyawan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder,$id)
    {
        $model = Karyawan::find($id);
        unset($model['password']);
        $form = $formBuilder->create(\App\Forms\Karyawan::class, [
            'method' => 'PUT',
            'route' => ['master.karyawan.update',$id],
            'model' =>$model
        ]);

        $title= 'Ubah Data Master Karyawan';

        return view('masterdata.form',compact('form','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $validate = $this->validate($request,[
            'id'=>'required|unique:karyawan,id,'.$id,
            'username'=>'required|unique:karyawan,username,'.$id,
            'profil_pic'=>'max:2000|image|mimes:jpg,png,jpeg,gif'
        ]);

         if($request->hasFile('profil_pic')){
            $image      = $request->file('profil_pic');
            $fileName   = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('public_upload')->put($fileName,file_get_contents($image));
            $request['photo']='img/'.$fileName;
        }else{
            $request['photo']=asset('img/default-user.png');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Karyawan::find($id)->delete();
        Alert::success('Data Deleted');
        return redirect('master/karyawan');
    }
}
