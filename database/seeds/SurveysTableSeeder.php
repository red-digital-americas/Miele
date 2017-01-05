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
class SurveysTableSeeder extends Seeder{
    public function run() {
        DB::table('mst_Surveys')->insert([
            "id"            => 1,
            'name'          => "Miele 2016",
            'welcome_text'  => "¡Bienvenido(a)!",
            'finish_text'   => "¡Gracias por participar!",
            'idSurveyType'  => 1,
            'created_by'    => 1
        ]);
        
        DB::table('mst_Surveys')->insert([
            "id"            => 2,
            'name'          => "Miele 2016",
            'welcome_text'  => "¡Bienvenido(a)!",
            'finish_text'   => "¡Gracias por participar!",
            'idSurveyType'  => 2,
            'created_by'    => 1
        ]);
        
        DB::table('mst_Surveys')->insert([
            "id"            => 3,
            'name'          => "Miele 2016",
            'welcome_text'  => "¡Bienvenido(a)!",
            'finish_text'   => "¡Gracias por participar!",
            'idSurveyType'  => 3,
            'created_by'    => 1
        ]);
        
        DB::table('mst_Surveys')->insert([
            "id"            => 4,
            'name'          => "Miele 2016",
            'welcome_text'  => "¡Bienvenido(a)!",
            'finish_text'   => "¡Gracias por participar!",
            'idSurveyType'  => 4,
            'created_by'    => 1
        ]);
    }

}
