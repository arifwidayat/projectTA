<?php

namespace App\DataTables;

use App\Models\JatahCuti;
use Yajra\Datatables\Services\DataTable;

class JatahCutiDataTable extends DataTable
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
            ->addColumn('nama',function($row){
                return $row->karyawan->nama;
            })
            ->addColumn('action', function($row){
                return '<a href="'.route('master.jatah-cuti.edit',$row->getKey()).'" class="btn btn-sm btn-primary">Ubah</a>
                         <form style="display:inline-block" action="'.route('master.jatah-cuti.destroy',$row->getKey()).'" method="POST">'.csrf_field().method_field('DELETE').'
                                  <button class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure want to delete this data?\')">Hapus</button>
                                </form>
                ';
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
        $query = JatahCuti::query();
        $query->with('karyawan');

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
            'karyawan_id'=>[
                'title' =>'No Karyawan',
            ],
            'nama'=>[
                'name'=>'karyawan.nama'
            ],
            'tahun',
            'jumlah_cuti',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'jatahcutis_' . time();
    }
}
