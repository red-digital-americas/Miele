<?php

/**
 * Description of catQuestionType
 *
 * @author Daniel Luna dluna@aper.net
 */

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\catQuestionType;
use App\Http\Controllers\api\v1\Api;

class CatQuestionTypeController extends Api {

    public function __construct() {
        $this->setArrayCreate([
            'name' => 'string|required|max:100|min:3',
            'icon' => 'string|required|max:100|min:3'
        ]);

        $this->setArrayUpdate([
            'id' => 'integer|required',
            'name' => 'string|max:100|min:3',
            'icon' => 'string|max:100|min:1'
        ]);

        $this->setArrayDelete([
            'id' => 'integer|required|'
        ]);

        parent::__construct();
    }

    public function index() {
        $catSurveys = catQuestionType::with("answerType")->get();
        return response()->json($catSurveys);
    }

    public function create(Request $request) {
        if (!($validate = $this->validateRequest($request, "create")) == true)
            return $validate;

        if ($this->getQuestionTypeByName($request->get("name")) != NULL)
            return response()->json(["status" => false, "message" => "already exists this question type name"]);

        if (($newSurvey = catQuestionType::create($request->all()))) {
            $this->setValuesRestrictedOfCreate($newSurvey);
            return response()->json(["status" => true, "message" => "question type created", "questionType" => $newSurvey]);
        } else
            return response()->json(["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION,
                        IlluminateResponse::HTTP_BAD_REQUEST]);
    }

    public function update(Request $request) {
        if (!($validate = $this->validateRequest($request, "update")) == true)
            return $validate;

        if (($currentSurvey = $this->getQuestionTypeById($request->get("id"))) == NULL)
            return response()->json(["status" => false, "message" => "the question type doesn't exists"]);

        if (strcasecmp($currentSurvey->name, $request->get("name")) != 0)
            if ($this->checkIfNewNameExists($request->get("id"),$request->get("name")))
                return response()->json(["status" => false, "message" => "already exists this survey name"]);

        if ($currentSurvey->update($request->all())) {
            $this->setValuesRestrictedUpdate($currentSurvey);
            return response()->json(["status" => true, "message" => "question type updated"]);
        } else
            return response()->json(["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }

    public function delete(Request $request) {
        if (!($validate = $this->validateRequest($request, "delete")) == true)
            return $validate;

        if (($survey = $this->getQuestionTypeById($request->get("id"))) == NULL)
            return response()->json(["status" => false, "message" => "the question type doesn't exists"]);

        $survey->status = ((int) $request->get("reactivate") == 1) ? 1 : 0;

        if ($this->setValuesRestrictedUpdate($survey))
            return ((int) $request->get("reactivate") == 1) ?
                    response()->json(["status" => true, "message" => "question type reactivated"]) :
                    response()->json(["status" => true, "message" => "question type deactivated"]);
        else
            return response()->json(["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }

    private function getQuestionTypeById($id) {
        return catQuestionType::find($id);
    }

    private function getQuestionTypeByName($name) {
        return catQuestionType::where("name", $name)->first();
    }

    private function checkIfNewNameExists($id, $newName) {
        return ((catQuestionType::where("name", $newName)->where("id", '!=', $id)->first()) != NULL) ? true : false;
    }

}
