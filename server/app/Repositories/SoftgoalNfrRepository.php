<?php

namespace App\Repositories;

use App\Models\SoftgoalNfr;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SoftgoalNfrRepository
 * @package App\Repositories
 * @version November 6, 2017, 10:36 pm UTC
 *
 * @method SoftgoalNfr findWithoutFail($id, $columns = ['*'])
 * @method SoftgoalNfr find($id, $columns = ['*'])
 * @method SoftgoalNfr first($columns = ['*'])
*/
class SoftgoalNfrRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'softgoals_id',
        'nfrs_id',
        'date',
        'time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SoftgoalNfr::class;
    }
}
