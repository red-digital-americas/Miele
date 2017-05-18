<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of QuestionType
 *
 * @author danielunag
 */
class catQuestionType extends Model{
    public $table = "cat_QuestionType";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "text",
        'icon',
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

    public function answerType() {
        return $this->hasMany('App\catAnswerType', 'idQuestionType');
    }

}
