<?php

namespace App\DataTables;

use App\Models\Permise;
use Form;
use Yajra\Datatables\Services\DataTable;

class PermiseDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'permises.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $permises = Permise::query();

        return $this->applyScopes($permises);
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
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    'print',
                    'reset',
                    'reload',
                    [
                         'extend'  => 'collection',
                         'text'    => '<i class="fa fa-download"></i> Export',
                         'buttons' => [
                             'csv',
                             'excel',
                             'pdf',
                         ],
                    ],
                    'colvis'
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'roles_id' => ['name' => 'roles_id', 'data' => 'roles_id'],
            'functionalities_id' => ['name' => 'functionalities_id', 'data' => 'functionalities_id'],
            'write' => ['name' => 'write', 'data' => 'write'],
            'erase' => ['name' => 'erase', 'data' => 'erase'],
            'update' => ['name' => 'update', 'data' => 'update'],
            'view' => ['name' => 'view', 'data' => 'view']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'permises';
    }
}
