<?php
/**
 * Description of mstQuestion
 *
 * @author danielunag
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class mstQuestionAnswer extends Model {

    public $table = "mst_QuestionAnswers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "text",
        "idQuestion",
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

}
