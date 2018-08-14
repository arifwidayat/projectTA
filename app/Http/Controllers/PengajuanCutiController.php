<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\DataTables\DaftarCutiDataTable;
use App\DataTables\PengajuanCutiDataTable;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\Cuti;
use App\Models\JatahCuti;
use Alert;

class PengajuanCutiController extends Controller
{

    public function indexCuti(DaftarCutiDataTable $cuti){
        $title= 'Rekapitulasi Cuti';
        return $cuti->render('masterdata.index',compact('title'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PengajuanCutiDataTable $cuti)
    {
        $this->cekjatahcuti();
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
        $this->cekjatahcuti();

        $cuti = Cuti::where('karyawan_id',auth()->id())->where('status','!=','verified')->count();
        
        $jatahcuti = JatahCuti::where('karyawan_id',auth()->id())->where('tahun',date('Y'))->first();

        if($cuti>0){
            Alert::warning('Maaf, Masih ada pengajuan cuti yang belum terverifikasi')->persistent('OK');
            return back();
        }

        if(is_null($jatahcuti)||$jatahcuti->jumlah_cuti==0){
            Alert::warning('Maaf, Jumlah Cuti Anda Sudah Habis')->persistent('OK');
            return back();
        }
         $form = $formBuilder->create(\App\Forms\PengajuanCuti::class, [
            'method' => 'POST',
            'route' => 'pengajuan-cuti.store'
        ]);
        $title= 'Tambah Data Pengajuan Cuti';
        $sisacuti=JatahCuti::where('karyawan_id',auth()->id())->first();
        return view('masterdata.form',compact('form','title','sisacuti'));
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

        $period = \Carbon\CarbonPeriod::create($request->tanggal_mulai,$request->tanggal_selesai);
        $diff=0;
        foreach($period as $date){
            if(!$date->isSunday()){
                $diff++;
            }
        }

        if($request->jenis_cuti != 'Cuti Tahunan' && $diff>2){
            Alert::warning('Maaf, Pengambilan cuti untuk jenis '.strtolower($request->jenis_cuti).' maximal 2 hari')->persistent();
            return back()->withInput();
        }
        
        $jatahcuti = JatahCuti::where('karyawan_id',auth()->id())->where('tahun',date('Y'))->first();
        if(($jatahcuti->jumlah_cuti-$diff)<0){
            Alert::error('Maaf, Sisa Cuti tidak mencukupi')->persistent();
            return back()->withInput();
        }

        $request['no_pengajuan']=0;
        $request['tanggal_pengajuan']=date('Y-m-d');
        $request['karyawan_id']=auth()->id();
        if(auth()->user()->level=='karyawan'){
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
        $sisacuti=JatahCuti::where('karyawan_id',auth()->id())->first();

        return view('masterdata.form',compact('form','title','sisacuti'));
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

        $period = \Carbon\CarbonPeriod::create($request->tanggal_mulai,$request->tanggal_selesai);
        $diff=0;
        foreach($period as $date){
            if(!$date->isSunday()){
                $diff++;
            }
        }
        
        $jatahcuti = JatahCuti::where('karyawan_id',auth()->id())->where('tahun',date('Y'))->first();
        if(($jatahcuti->jumlah_cuti-$diff)<0){
            Alert::error('Maaf, Sisa Cuti tidak mencukupi');
            return back()->withInput();
        }

        $cuti = Cuti::find($id);
        $cuti->update($request->except(['_token']));
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
            $q->where('divisi_id',auth()->user()->divisi_id)->where('level','!=','kepala divisi');
        })->where('status','propose')->paginate(15);

        return view('pengajuan-cuti',compact('cuti','title'));
    }

    public function verifikasi(){
        $title='Validasi Pengajuan Cuti';
        $cuti = Cuti::where('karyawan_id','!=',auth()->user()->id)->where('status','approved')->paginate('15');
        return view('pengajuan-cuti',compact('cuti','title'));
    }

    public function status($id,$status){
        $cuti = Cuti::find($id);
        $period = \Carbon\CarbonPeriod::create($cuti->tanggal_mulai,$cuti->tanggal_selesai);
        $diff=0;
        foreach($period as $date){
            if(!$date->isSunday()){
                $diff++;
            }
        }
        $update['status']=$status;
        if(request()->has('keterangan')){   
            $update['keterangan_ditolak']=request()->get('keterangan');
        }

        $cuti->update($update);
        $jatahcuti=JatahCuti::where('karyawan_id',$cuti->karyawan_id)->first();

        if($status=='approved'){
            $status='Diterima';
        }elseif($status=='verified'){
            if($cuti->jenis_cuti=='Cuti Tahunan'){   
                $jatahcuti->update(['jumlah_cuti'=>($jatahcuti->jumlah_cuti-$diff)]);
            }
            $status='Diverifikasi';
        }elseif($status=='rejected'){
            $status='Ditolak';
        }
        Alert::success('Pengajuan Berhasil '.$status);
        return back();
    }
}
