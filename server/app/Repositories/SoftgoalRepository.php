<?php

namespace App\Repositories;

use App\Models\Softgoal;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SoftgoalRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:36 pm UTC
 *
 * @method Softgoal findWithoutFail($id, $columns = ['*'])
 * @method Softgoal find($id, $columns = ['*'])
 * @method Softgoal first($columns = ['*'])
*/
class SoftgoalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'goals_id',
        'relevances_id',
        'date',
        'time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Softgoal::class;
    }
}
