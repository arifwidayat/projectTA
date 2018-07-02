<?php

namespace App\DataTables;

use App\Models\Jabatan;
use Yajra\Datatables\Services\DataTable;

class JabatanDataTable extends DataTable
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
            ->addColumn('action', function($row){
                return '<a href="'.route('master.jabatan.edit',$row->getKey()).'" class="btn btn-sm btn-primary">Ubah</a>
                         <form style="display:inline-block" action="'.route('master.jabatan.destroy',$row->getKey()).'" method="POST">'.csrf_field().method_field('DELETE').'
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
        $query = Jabatan::query();

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
                    ->addAction(['width' => '80px'])
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
            'nama',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'jabatandatatables_' . time();
    }
}
