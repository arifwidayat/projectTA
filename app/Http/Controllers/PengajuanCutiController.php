<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DataTables\PengajuanCutiDataTable;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Cuti;
use Alert;

class PengajuanCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PengajuanCutiDataTable $cuti)
    {
        $title= 'Data Pengajuan Cuti';
        $link = route('pengajuan-cuti.create');
        return $cuti->render('masterdata.index',compact('title','link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {

        $cuti = Cuti::where('karyawan_id',auth()->id())->where('status','propose')->count();
        if($cuti>0){
            Alert::warning('Maaf, Masih ada pengajuan cuti yang belum selesai')->persistent('OK');
            return back();
        }
         $form = $formBuilder->create(\App\Forms\PengajuanCuti::class, [
            'method' => 'POST',
            'route' => 'pengajuan-cuti.store'
        ]);
        $title= 'Tambah Data Pengajuan Cuti';
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
        if(strtotime($request->get('tanggal_mulai'))>strtotime($request->get('tanggal_selesai'))){
        return back()->withErrors(['tanggal_selesai'=>'The tanggal selesai must be a date equal or after tanggal mulai.'])->withInput();
        }
        $request['no_pengajuan']=0;
        $request['tanggal_pengajuan']=date('Y-m-d');
        $request['karyawan_id']=auth()->id();
        if(auth()->user()->jabatan=='karyawan'){
            $request['status']='propose';
        }else{
            $request['status']='approved';
        }
        $cuti = Cuti::create($request->except(['_token']));
        $cuti->no_pengajuan=$cuti->id;
        $cuti->save();
        Alert::success('Data Berhasil Ditambahkan');
        return redirect('pengajuan-cuti');
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
        $model = Cuti::find($id);
        $form = $formBuilder->create(\App\Forms\PengajuanCuti::class, [
            'method' => 'PUT',
            'route' => ['pengajuan-cuti.update',$id],
            'model' =>$model
        ]);

        $title= 'Ubah Data Pengajuan Cuti';

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
        Cuti::find($id)->update($request->except(['_token']));
        Alert::success('Data Berhasil Diubah');
        return redirect('pengajuan-cuti');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cuti::find($id)->delete();
        Alert::success('Data Deleted');
        return redirect('pengajuan-cuti');
    }

    public function approval(){
        $title='Approval Pengajuan Cuti';
        $cuti = Cuti::whereHas('karyawan',function($q){
            $q->where('divisi_id',auth()->user()->divisi_id)->where('jabatan','!=','kepala divisi');
        })->where('status','propose')->limit('15');
        
        return view('pengajuan-cuti',compact('cuti','title'));
    }

    public function verifikasi(){
        $title='Verifikasi Pengajuan Cuti';
        $cuti = Cuti::where('status','approved')->limit('15');
        return view('pengajuan-cuti',compact('cuti','title'));
    }

    public function status($id,$status){
        Cuti::find($id)->update(['status'=>$status]);
        if($status=='approved'){
            $status='Diterima';
        }elseif($status=='verified'){
            $status='Diverifikasi';
        }elseif($status=='rejected'){
            $status='Ditolak';
        }
        Alert::success('Pengajuan Berhasil '.$status);
        return back();
    }
}
