<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class mstSurveyAnswer extends Model{
//    public $timestamps = false;
    public $table = 'mst_SurveyAnswer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer',
        'idQuestion',
        'idQuestionAnswer',
        'idAnswerType',
        'idSurveyApplied'
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
    
    public function surveyApplied() {
        return $this->hasOne('App\mstSurveyApplied', 'id', 'idSurveyApplied');
    }
    
    public function question(){
        return $this->belongsTo('App\mstQuestion', 'idQuestion', 'id');
    }
}
