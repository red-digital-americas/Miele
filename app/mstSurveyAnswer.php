<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class mstSurveyAnswer extends Model implements AuthenticatableContract, AuthorizableContract{
    use Authenticatable, Authorizable;
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
        "created_at",
        "updated_at",
        "updated_by",
        "status"
    ];
}
