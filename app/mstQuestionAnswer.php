<?php
/**
 * Description of mstQuestion
 *
 * @author danielunag
 */

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
class mstQuestionAnswer extends Model implements AuthenticatableContract, AuthorizableContract {

    public $table = "mst_QuestionAnswers";

    use Authenticatable,
        Authorizable;

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
