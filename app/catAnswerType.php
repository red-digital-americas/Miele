<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * Description of catAnswerType
 *
 * @author danielunag
 */
class catAnswerType extends Model{

    public $table = "cat_AnswerType";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "text",
        "idQuestionType"
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

}
