<?php

namespace App\Repositories;

use App\Models\Share;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ShareRepository
 * @package App\Repositories
 * @version November 14, 2017, 8:50 pm UTC
 *
 * @method Share findWithoutFail($id, $columns = ['*'])
 * @method Share find($id, $columns = ['*'])
 * @method Share first($columns = ['*'])
*/
class ShareRepository extends BaseRepository
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
        return Share::class;
    }
}
