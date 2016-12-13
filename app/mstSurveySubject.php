<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of mstSurveySubject
 *
 * @author danielunag
 */
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
class mstSurveySubject extends Model implements AuthenticatableContract, AuthorizableContract{
    use Authenticatable, Authorizable;
//    public $timestamp = false;
    public $table = 'mst_SurveySubject';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "last_name",
        "mothers_last_name",
        "birthday",
        "addres",
        "telephone"
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
