<?php

/**
 * Description of mstQuestion
 *
 * @author danielunag
 */

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class mstQuestion extends Model implements AuthenticatableContract, AuthorizableContract {

    public $table = "mst_Questions";

    use Authenticatable,
        Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "text",
        "idSurvey",
        "idQuestionType",
        "status"
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        "created_by",
        "updated_at",
        "updated_by",
        "status"
    ];

    public function questionAnswers() {
        return $this->hasMany('App\mstQuestionAnswer', 'idQuestion', 'id');
    }
    
    public function catQuestionType() {
        return $this->hasOne('App\catQuestionType', 'id', 'idQuestionType');
    }

}
