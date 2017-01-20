<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QuestionTypeSeeder
 *
 * @author danielunag
 */
use Illuminate\Database\Seeder;
class QuestionTypeSeeder extends Seeder{
    public function run() {
        DB::table('cat_QuestionType')->insert([
            'id'            => 1,
            'name'          => "Pregunta abierta",
            'icon'         => "glyphicon glyphicon-question-sign",
            'created_by'    => 1
        ]);
        
        DB::table('cat_QuestionType')->insert([
            'id'            => 2,
            'name'          => "Opción Múltiple / Una respuesta",
            'icon'         => "glyphicon glyphicon-record",
            'created_by'    => 1
        ]);
        
        DB::table('cat_QuestionType')->insert([
            'id'            => 3,
            'name'          => "Opción Múltiple / Varias Respuestas",
            'icon'         => "glyphicon glyphicon-check",
            'created_by'    => 1
        ]);
        
        DB::table('cat_QuestionType')->insert([
            'id'            => 4,
            'name'          => "Pregunta de satisfacción",
            'icon'         => "glyphicon glyphicon-heart",
            'created_by'    => 1
        ]);
        
        DB::table('cat_QuestionType')->insert([
            'id'            => 5,
            'name'          => "Puntuación",
            'icon'          => "glyphicon glyphicon-star-empty",
            'created_by'    => 1
        ]);
        
        DB::table('cat_QuestionType')->insert([
            'id'            => 6,
            'name'          => "Texto simple",
            'icon'          => "glyphicon glyphicon-font",
            'created_by'    => 1
        ]);
        
        DB::table('cat_QuestionType')->insert([
            'id'            => 7,
            'name'          => "Si / NO",
            'icon'          => "glyphicon glyphicon-thumbs-up",
            'created_by'    => 1
        ]);
    }
}
