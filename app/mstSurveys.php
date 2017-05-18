<?php

/**
 * Description of mstSurveys
 *
 * @author danielunag
 */

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;

class mstSurveys extends Model {
    public $table = 'mst_Surveys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "name",
        "welcome_text",
        "finish_text",
        "idSurveyType",
        "anon",
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
        "updated_by"
    ];

    public function surveyType() {
        return $this->hasMany('App\catSurveyType', 'id', 'idSurveyType');
    }

    public function mstQuestions() {
        return $this->hasMany('App\mstQuestion', 'idSurvey');
    }
    
}
