<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DataTables\JabatanDataTable;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Jabatan;
use Alert;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JabatanDataTable $jabatan)
    {
        $title= 'Data Master Jabatan';
        $link = route('master.jabatan.create');
        return $jabatan->render('masterdata.index',compact('title','link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\Jabatan::class, [
            'method' => 'POST',
            'route' => 'master.jabatan.store'
        ]);
        $title= 'Tambah Data Jabatan';
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
            'nama'=>'required|unique:jabatan,nama',
        ]);

        Jabatan::create($request->except(['_token']));
        Alert::success('Data Berhasil Ditambahkan');
        return redirect('master/jabatan');
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
        $model = Jabatan::find($id);
        $form = $formBuilder->create(\App\Forms\Jabatan::class, [
            'method' => 'PUT',
            'route' => ['master.jabatan.update',$id],
            'model' =>$model
        ]);

        $title= 'Ubah Data Master Jabatan';

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
            'nama'=>'required|unique:jabatan,nama,'.$id,
        ]);

        Jabatan::find($id)->update($request->except(['_token']));
        Alert::success('Data Berhasil Diubah');
        return redirect('master/jabatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Jabatan::find($id)->delete();
        Alert::success('Data Deleted');
        return redirect('master/jabatan');
    }
}
