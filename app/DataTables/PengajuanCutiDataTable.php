<?php

namespace App\DataTables;

use App\Models\Cuti;
use Yajra\Datatables\Services\DataTable;

class PengajuanCutiDataTable extends DataTable
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
            ->editColumn('tanggal_pengajuan',function($row){
                return date('d M Y',strtotime($row->tanggal_pengajuan));
            })
            ->editColumn('tanggal_cuti',function($row){
                return date('d M Y',strtotime($row->tanggal_mulai)).' - '.date('d M Y',strtotime($row->tanggal_selesai));
            })
            ->editColumn('keterangan',function($row){
                return ($row->keterangan)?:'-';
            })
            ->addColumn('action', function($row){
                if($row->status=='verified'||$row->status=='rejected'){
                    return '-';
                }else{
                    return '<a href="'.route('pengajuan-cuti.edit',$row->getKey()).'" class="btn btn-sm btn-primary">Ubah</a>
                             <form style="display:inline-block" action="'.route('pengajuan-cuti.destroy',$row->getKey()).'" method="POST">'.csrf_field().method_field('DELETE').'
                                      <button class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure want to delete this data?\')">Hapus</button>
                                    </form>';
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
        $query = Cuti::query()->where('karyawan_id',auth()->id());

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
                    ->addAction(['width' => '110px'])
                    ->parameters($this->getBuilderParameters());
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
            'jenis_cuti',
            'tanggal_pengajuan',
            'tanggal_cuti'=>['searchable'=>false],
            'keterangan',
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
        return 'pengajuancutis_' . time();
    }
}
