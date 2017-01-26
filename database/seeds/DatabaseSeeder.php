<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call('RolesTableSeeder');
         $this->call('UserTableSeeder');
         $this->call('SurveyTypeTableSeeder');
         $this->call('SurveysTableSeeder');
         $this->call('QuestionTypeSeeder');
         $this->call('AnswerTypeSeeder');
    }
}
