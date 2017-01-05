<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SurveysTableSeeder
 *
 * @author danielunag
 */
use Illuminate\Database\Seeder;
class SurveyTypeTableSeeder extends Seeder{
    public function run() {
        DB::table('cat_SurveyType')->insert([
            'id'            => 1,
            'name'          => "Servicio",
            'icon'          => "/img/surveyIcon/repairing.png",
            'created_by'    => 1
        ]);
        DB::table('cat_SurveyType')->insert([
            'id'            => 2,
            'name'          => "Eventos",
            'icon'          => "/img/surveyIcon/calendar.png",
            'created_by'    => 1
        ]);
        DB::table('cat_SurveyType')->insert([
            'id'            => 3,
            'name'          => "Ventas",
            'icon'          => "/img/surveyIcon/happy-face.png",
            'created_by'    => 1
        ]);
        DB::table('cat_SurveyType')->insert([
            'id'            => 4,
            'name'          => "Otros",
            'icon'          => "/img/surveyIcon/logo.png",
            'created_by'    => 1
        ]);
    }
}
