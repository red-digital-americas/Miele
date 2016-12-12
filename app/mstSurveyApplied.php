<?php
/**
 * Description of mstSurveyApplied
 *
 * @author danielunag
 */

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class mstSurveyApplied extends Model implements AuthenticatableContract, AuthorizableContract{
    use Authenticatable, Authorizable;
    public $timestamps = false;
    public $table = 'mst_SurveyApplied';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idSurveySubject',
        'idSurvey',
        'completed'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        "created_by",
        "created_at",
        "updated_at",
        "updated_by",
        "status"
    ];
}