<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DataTables\JatahCutiDataTable;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\JatahCuti;
use Alert;

class JatahCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JatahCutiDataTable $jatahcuti)
    {
        $title= 'Data Master Jatah Cuti';
        $link = route('master.jatah-cuti.create');
        return $jatahcuti->render('masterdata.index',compact('title','link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(\App\Forms\JatahCuti::class, [
            'method' => 'POST',
            'route' => 'master.jatah-cuti.store'
        ]);
        $title= 'Tambah Data Jatah Cuti';
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
        JatahCuti::updateOrCreate(['karyawan_id'=>$request->karyawan_id,'tahun'=>$request->tahun],['jumlah_cuti'=>$request->jumlah_cuti]);
        Alert::success('Data Berhasil Ditambahkan');
        return redirect('master/jatah-cuti');
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
        $model = JatahCuti::find($id);
        $form = $formBuilder->create(\App\Forms\JatahCuti::class, [
            'method' => 'PUT',
            'route' => ['master.jatah-cuti.update',$id],
            'model' =>$model
        ]);

        $title= 'Ubah Data Master Jatah Cuti';

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
        JatahCuti::find($id)->update($request->except(['_token']));
        Alert::success('Data Berhasil Diubah');
        return redirect('master/jatah-cuti');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        JatahCuti::find($id)->delete();
        Alert::success('Data Deleted');
        return redirect('master/jatah-cuti');
    }
}
