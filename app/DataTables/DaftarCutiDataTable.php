<?php

namespace App\DataTables;

use App\Models\Cuti;
use Yajra\Datatables\Services\DataTable;

class DaftarCutiDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('nama_karyawan',function($row){
                return $row->karyawan->nama;
            })
            ->editColumn('tanggal_pengajuan',function($row){
                return date('d M Y',strtotime($row->tanggal_pengajuan));
            })
            ->editColumn('tanggal_cuti',function($row){
                return date('d M Y',strtotime($row->tanggal_mulai)).' - '.date('d M Y',strtotime($row->tanggal_selesai));
            })
            ->editColumn('status',function($row){
                if($row->status == 'propose'){
                    return 'Menunggu Persetujuan Kepala Divisi';
                }elseif($row->status == 'approved'){
                    return 'Menunggu Verifikasi HRD';
                }elseif($row->status == 'rejected'){
                    return 'Pengajuan Ditolak';
                }elseif($row->status == 'verified'){
                    return 'Pengajuan Terverifikasi dan Dikabulkan';
                }
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Cuti::query()->with('karyawan');

        $start_date = '';
        $end_date = '';
        
        if(request()->get('date')){
            $date = explode('-',request()->get('date'));
            $start_date = \Carbon\Carbon::createFromFormat('d/m/Y',$date[0])->format('Y-m-d');
            $end_date = \Carbon\Carbon::createFromFormat('d/m/Y',$date[1])->format('Y-m-d');
            $query->whereBetween('tanggal_mulai',[$start_date,$end_date]);
        }

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                     ->parameters([
                        'dom' => "<<'col-xs-12 col-sm-12 col-md-12'B><'col-xs-12 col-sm-6 col-md-6'l><'col-xs-12 col-sm-6 col-md-6'f>>rtip",
                        'buttons' => ['excel', 'print'],
                    ]);
                    // ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'no_pengajuan',
            'nama_karyawan'=>['name'=>'karyawan.nama'],
            'tanggal_pengajuan',
            'tanggal_cuti'=>['searchable'=>false],
            'status',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'laporan_cuti_' . time();
    }
}
