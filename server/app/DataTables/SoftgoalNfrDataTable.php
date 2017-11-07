<?php

namespace App\DataTables;

use App\Models\SoftgoalNfr;
use Form;
use Yajra\Datatables\Services\DataTable;

class SoftgoalNfrDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'softgoal_nfrs.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $softgoalNfrs = SoftgoalNfr::query();

        return $this->applyScopes($softgoalNfrs);
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
            'softgoals_id' => ['name' => 'softgoals_id', 'data' => 'softgoals_id'],
            'nfrs_id' => ['name' => 'nfrs_id', 'data' => 'nfrs_id'],
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
        return 'softgoalNfrs';
    }
}
