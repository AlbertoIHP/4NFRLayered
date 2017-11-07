<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Permise",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="roles_id",
 *          description="roles_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="functionalities_id",
 *          description="functionalities_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="write",
 *          description="write",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="erase",
 *          description="erase",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="update",
 *          description="update",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="view",
 *          description="view",
 *          type="string"
 *      )
 * )
 */
class Permise extends Model
{
    use SoftDeletes;

    public $table = 'permissions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'roles_id',
        'functionalities_id',
        'write',
        'erase',
        'update',
        'view'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'roles_id' => 'integer',
        'functionalities_id' => 'integer',
        'write' => 'string',
        'erase' => 'string',
        'update' => 'string',
        'view' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function functionality()
    {
        return $this->belongsTo(\App\Models\Functionality::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }
    protected $hidden = ['remember_token', 'updated_at', 'created_at', 'deleted_at'];
}
