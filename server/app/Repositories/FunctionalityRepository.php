<?php

namespace App\Repositories;

use App\Models\Functionality;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FunctionalityRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:34 pm UTC
 *
 * @method Functionality findWithoutFail($id, $columns = ['*'])
 * @method Functionality find($id, $columns = ['*'])
 * @method Functionality first($columns = ['*'])
*/
class FunctionalityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Functionality::class;
    }
}
