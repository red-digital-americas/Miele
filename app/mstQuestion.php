<?php

/**
 * Description of mstQuestion
 *
 * @author danielunag
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class mstQuestion extends Model {
    public $table = "mst_Questions";

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
    
    public function surveyAnswer(){
        return $this->hasMany('App\mstSurveyAnswer', 'idQuestion', 'id');
    }

}
