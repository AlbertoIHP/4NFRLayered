<?php

namespace App\DataTables;

use App\Models\Project;
use Form;
use Yajra\Datatables\Services\DataTable;

class ProjectDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'projects.datatables_actions')
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $projects = Project::query();

        return $this->applyScopes($projects);
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
            'description' => ['name' => 'description', 'data' => 'description'],
            'time' => ['name' => 'time', 'data' => 'time'],
            'date' => ['name' => 'date', 'data' => 'date'],
            'users_id' => ['name' => 'users_id', 'data' => 'users_id'],
            'areas_id' => ['name' => 'areas_id', 'data' => 'areas_id'],
            'deadline' => ['name' => 'deadline', 'data' => 'deadline']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'projects';
    }
}
