<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DataTables\DivisiDataTable;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Divisi;
use Alert;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DivisiDataTable $divisi)
    {
        $title= 'Data Master Divisi';
        $link = route('master.divisi.create');
        return $divisi->render('masterdata.index',compact('title','link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\Divisi::class, [
            'method' => 'POST',
            'route' => 'master.divisi.store'
        ]);
        $title= 'Tambah Data Divisi';
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
            'nama'=>'required|unique:divisi,nama',
        ]);

        Divisi::create($request->except(['_token']));
        Alert::success('Data Berhasil Ditambahkan');
        return redirect('master/divisi');
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
        $model = Divisi::find($id);
        $form = $formBuilder->create(\App\Forms\Divisi::class, [
            'method' => 'PUT',
            'route' => ['master.divisi.update',$id],
            'model' =>$model
        ]);

        $title= 'Ubah Data Master Divisi';

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
            'nama'=>'required|unique:divisi,nama,'.$id,
        ]);

        Divisi::find($id)->update($request->except(['_token']));
        Alert::success('Data Berhasil Diubah');
        return redirect('master/divisi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Divisi::find($id)->delete();
        Alert::success('Data Deleted');
        return redirect('master/divisi');
    }
}
