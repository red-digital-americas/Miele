<?php
/**
 * Description of AnswerType
 *
 * @author Daniel Luna dluna@aper.net
 */

use Illuminate\Database\Seeder;

class AnswerTypeSeeder extends Seeder{
     public function run() {        
        
        DB::table('cat_AnswerType')->insert([
            'id'            => 1,
            'name'          => "Muy satisfecho",
            'idQuestionType'=> 4
        ]);
        
        DB::table('cat_AnswerType')->insert([
            'id'            => 2,
            'name'          => "Satisfecho",
            'idQuestionType'=> 4
        ]);
        
        DB::table('cat_AnswerType')->insert([
            'id'            => 3,
            'name'          => "Poco satisfecho",
            'idQuestionType'=> 4
        ]);
        
        DB::table('cat_AnswerType')->insert([
            'id'            => 4,
            'name'          => "Nada",
            'idQuestionType'=> 4
        ]);
        
        DB::table('cat_AnswerType')->insert([
            'id'            => 5,
            'name'          => "Si",
            'idQuestionType'=> 7
        ]);
        
        DB::table('cat_AnswerType')->insert([
            'id'            => 6,
            'name'          => "No",
            'idQuestionType'=> 7
        ]);
    }
}
