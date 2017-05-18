<?php
/**
 *
 * @author Daniel Luna    dluna@aper.net
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class mstRoles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'created_by',
        'updated_by',
        'updated_at',
        'status'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User','id');
    }
}
