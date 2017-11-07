<?php

namespace App\Repositories;

use App\Models\Relevance;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RelevanceRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:33 pm UTC
 *
 * @method Relevance findWithoutFail($id, $columns = ['*'])
 * @method Relevance find($id, $columns = ['*'])
 * @method Relevance first($columns = ['*'])
*/
class RelevanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'weigth'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Relevance::class;
    }
}
