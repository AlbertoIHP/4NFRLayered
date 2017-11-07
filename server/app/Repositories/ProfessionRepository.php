<?php

namespace App\Repositories;

use App\Models\Profession;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ProfessionRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:34 pm UTC
 *
 * @method Profession findWithoutFail($id, $columns = ['*'])
 * @method Profession find($id, $columns = ['*'])
 * @method Profession first($columns = ['*'])
*/
class ProfessionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Profession::class;
    }
}
