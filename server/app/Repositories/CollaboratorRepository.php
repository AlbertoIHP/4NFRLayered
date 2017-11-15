<?php

namespace App\Repositories;

use App\Models\Collaborator;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CollaboratorRepository
 * @package App\Repositories
 * @version November 15, 2017, 1:24 am UTC
 *
 * @method Collaborator findWithoutFail($id, $columns = ['*'])
 * @method Collaborator find($id, $columns = ['*'])
 * @method Collaborator first($columns = ['*'])
*/
class CollaboratorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'users_id',
        'projects_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Collaborator::class;
    }
}
