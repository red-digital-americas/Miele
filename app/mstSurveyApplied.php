<?php
/**
 * Description of mstSurveyApplied
 *
 * @author danielunag
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class mstSurveyApplied extends Model{
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
        "updated_at",
        "updated_by",
        "status"
    ];
    
    public function surveySubject() {
        return $this->hasOne('App\mstSurveySubject', 'id', 'idSurveySubject');
    }
    
    public function surveyAnswer(){
        return $this->hasMany('App\mstSurveyAnswer', 'idSurveyApplied', 'id');
    }
    
    public function survey(){
        return $this->belongsTo('App\mstSurveys', 'idSurvey', 'id');
    }
}