<?php

namespace App\Repositories;

use App\Models\Goal;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class GoalRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:35 pm UTC
 *
 * @method Goal findWithoutFail($id, $columns = ['*'])
 * @method Goal find($id, $columns = ['*'])
 * @method Goal first($columns = ['*'])
*/
class GoalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'stakeholders_id',
        'relevances_id',
        'date',
        'time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Goal::class;
    }
}
