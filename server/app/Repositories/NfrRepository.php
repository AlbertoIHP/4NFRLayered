<?php

namespace App\Repositories;

use App\Models\Nfr;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class NfrRepository
 * @package App\Repositories
 * @version November 6, 2017, 11:05 pm UTC
 *
 * @method Nfr findWithoutFail($id, $columns = ['*'])
 * @method Nfr find($id, $columns = ['*'])
 * @method Nfr first($columns = ['*'])
*/
class NfrRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'categories_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Nfr::class;
    }
}
