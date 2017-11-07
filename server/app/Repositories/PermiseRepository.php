<?php

namespace App\Repositories;

use App\Models\Permise;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PermiseRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:35 pm UTC
 *
 * @method Permise findWithoutFail($id, $columns = ['*'])
 * @method Permise find($id, $columns = ['*'])
 * @method Permise first($columns = ['*'])
*/
class PermiseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'roles_id',
        'functionalities_id',
        'write',
        'erase',
        'update',
        'view'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permise::class;
    }
}
