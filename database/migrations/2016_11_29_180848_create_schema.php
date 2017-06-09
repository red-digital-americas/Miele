<?php

/**
 * This script generates the Model of the Survey System and the catalog product tables.
 *
 * @author Daniel Luna dluna@aper.net
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchema extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        /*      ---- Survey System Tables ----      */
        Schema::create('log_Session', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('event', 255)                ->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
        });

        Schema::create('log_Tran', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('event', 255)                ->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
        });

        Schema::create('log_Error', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('event', 255)                ->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
        });
        
        Schema::create('mst_Newsletter', function(Blueprint $table){
            $table->increments('id');
            $table->string('email', 45)                 ->nullable(false)->unique();
        });
        
        

        Schema::create('cat_SurveyType', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('name', 100)                 ->nullable(false);
            $table->string('icon')                      ->nullable(false);
            $table->string('color')                     ->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->boolean('status')                   ->default(1);
            
//            $table->foreign('id')->references('id')->on('mst_Surveys');
        });
        
        Schema::create('mst_Surveys', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('name', 100)                 ->nullable(false);
            $table->string('welcome_text', 255)         ->nullable();
            $table->string('finish_text', 255)          ->nullable();
            $table->integer('idSurveyType')             ->unsigned()->nullable(false);
            $table->boolean('anon')->nullable(false)    ->default(0);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamps();
            $table->boolean('status')                   ->default(1);
            
            $table->foreign('idSurveyType')->references('id')->on('cat_SurveyType');
        });
        
        Schema::create('cat_QuestionType', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('name', 255)                 ->nullable(false);
            $table->string('icon', 255)                 ->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->boolean('status')                   ->nullable(false)->default(1);            
        });
        
        Schema::create('mst_Questions', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('text', 255)             ->nullable(false);
            $table->boolean('required')                 ->nullable(false)->default(0);
            $table->integer('idSurvey')                 ->unsigned()->nullable(false);
            $table->integer('idQuestionType')           ->unsigned()->nullable(false);
            $table->integer('idParent')                 ->nullable(false)->default(0);
            $table->string('answer')         ->nullable()->default(null);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->boolean('status')                   ->default(1);
            
            $table->foreign('idSurvey')->references('id')->on('mst_Surveys');
            $table->foreign('idQuestionType')->references('id')->on('cat_QuestionType');
        });
        
        Schema::create('cat_AnswerType', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('name', 45)                  ->nullable(false);
            $table->integer('idQuestionType')           ->unsigned()->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->boolean('status')                   ->default(1);
            
            $table->foreign('idQuestionType')->references('id')->on('cat_QuestionType');
        });

        Schema::create('mst_QuestionAnswers', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('text', 255)               ->nullable(false);
            $table->integer('idQuestion')               ->unsigned()->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->boolean('status')                   ->default(1);
            
            $table->foreign('idQuestion')->references('id')->on('mst_Questions');
        });

        Schema::create('mst_SurveyApplied', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->integer('idSurveySubject')          ->nullable();
            $table->integer('idSurvey')                 ->unsigned()->nullable(false);
            $table->boolean('completed')                ->default(0);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            
            $table->foreign('idSurvey')->references('id')->on('mst_Surveys');
        });

        Schema::create('mst_SurveyAnswer', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('answer')                    ->nullable();
            $table->integer('idQuestion')               ->unsigned()->nullable(false);
            $table->integer('idQuestionAnswer')         ->nullable();
            $table->integer('idAnswerType')             ->nullable();
            $table->integer('idSurveyApplied')          ->unsigned()->nullable(false);
            $table->timestamps();
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            
            $table->foreign('idQuestion')->references('id')->on('mst_Questions');
            $table->foreign('idSurveyApplied')->references('id')->on('mst_SurveyApplied');
        });

        Schema::create('mst_SurveySubject', function (Blueprint $table) {
            $table->increments('id')       ->nullable(false);
            $table->string('name', 45)                  ->nullable(false);
            $table->string('last_name', 45)             ->nullable(false);
            $table->string('mothers_last_name', 45)     ->nullable();
            $table->date('birthday')                    ->nullable();
            $table->string('gender',2)                  ->nullable();
            $table->string('address')                   ->nullable();
            $table->string('telephone')                 ->nullable();
            $table->string('email',45)                  ->nullable(false);
            $table->boolean('newsletter')               ->nullable(false);
            $table->boolean('eventSubscription')        ->nullable(false);
            $table->timestamp('created_at')             ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
        });

        /*      ---- Product Catalog Tables ----        */

        Schema::create('cat_CatProduct', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('name', 255)                 ->nullable(false);
            $table->integer('parent_id')                ->nullable(false);
            $table->boolean('status')                   ->nullable(false)->default(1);
            
        });
        
        Schema::create('cat_Products', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->integer('idCatProduct')             ->nullable(false)->unsigned();
            $table->string('name', 255)                 ->nullable(false);
            $table->string('description', 255)          ->nullable();
            $table->string('material', 255)             ->nullable(false);
            $table->string('sku', 255)                  ->nullable(false);
            $table->string('features', 255)             ->nullable(false);
            $table->string('description_accesories')    ->nullable(false);
            $table->string('comments')                  ->nullable();
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->boolean('status')                   ->default(1);
            
            $table->foreign('idCatProduct')->references('id')->on('cat_CatProduct');
        });

        Schema::create('mst_ProdVar', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('var_name')                  ->nullable(false);
            $table->integer('idProduct')->unsigned()    ->nullable(false);
            
            $table->foreign('idProduct')->references('id')->on('cat_Products');
        });

        Schema::create('mst_CatProdMedia', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->integer('idCatProduct')             ->unsigned()->nullable(false);
            $table->string('path', 255)                 ->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            
            $table->foreign('idCatProduct')->references('id')->on('cat_CatProduct');
        });
        
        Schema::create('mst_Media', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->integer('idProdVar')                ->nullable(false)->unsigned();
            $table->string('path', 255)                 ->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->string('ext', 10)                   ->nullable(false);
            
            $table->foreign('idProdVar')->references('id')->on('mst_ProdVar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        /*      --- Survey System ---       */
            Schema::dropIfExists('log_Tran');
            Schema::dropIfExists('log_Session');
            Schema::dropIfExists('log_Error');
            Schema::dropIfExists('mst_Newsletter');
            Schema::dropIfExists('mst_SurveySubject');
            Schema::dropIfExists('mst_SurveyAnswer');
            Schema::dropIfExists('mst_SurveyApplied');
            Schema::dropIfExists('mst_QuestionAnswers');
            Schema::dropIfExists('cat_AnswerType');
            Schema::dropIfExists('mst_Questions');
            Schema::dropIfExists('cat_QuestionType');
            Schema::dropIfExists('mst_Surveys');
            Schema::dropIfExists('cat_SurveyType');
        /*      --- Survey System ---       */
            Schema::dropIfExists('mst_Media');
            Schema::dropIfExists('mst_CatProdMedia');
            Schema::dropIfExists('mst_ProdVar');
            Schema::dropIfExists('cat_Products');
            Schema::dropIfExists('cat_CatProduct');   
    }

}
