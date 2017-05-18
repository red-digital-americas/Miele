<?php
/**
 * Description of catSurveysType
 *
 * @author danielunag
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class catSurveyType extends Model{
    public $table = 'cat_SurveyType';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "id",
        "name",
        "status"
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
