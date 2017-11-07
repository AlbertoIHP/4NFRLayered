<?php

namespace App\Repositories;

use App\Models\Stakeholder;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StakeholderRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:35 pm UTC
 *
 * @method Stakeholder findWithoutFail($id, $columns = ['*'])
 * @method Stakeholder find($id, $columns = ['*'])
 * @method Stakeholder first($columns = ['*'])
*/
class StakeholderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'decription',
        'function',
        'projects_id',
        'professions_id',
        'date',
        'time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Stakeholder::class;
    }
}
