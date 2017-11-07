<?php

namespace App\DataTables;

use App\Models\Stakeholder;
use Form;
use Yajra\Datatables\Services\DataTable;

class StakeholderDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'stakeholders.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $stakeholders = Stakeholder::query();

        return $this->applyScopes($stakeholders);
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
            'name' => ['name' => 'name', 'data' => 'name'],
            'decription' => ['name' => 'decription', 'data' => 'decription'],
            'function' => ['name' => 'function', 'data' => 'function'],
            'projects_id' => ['name' => 'projects_id', 'data' => 'projects_id'],
            'professions_id' => ['name' => 'professions_id', 'data' => 'professions_id'],
            'date' => ['name' => 'date', 'data' => 'date'],
            'time' => ['name' => 'time', 'data' => 'time']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'stakeholders';
    }
}
