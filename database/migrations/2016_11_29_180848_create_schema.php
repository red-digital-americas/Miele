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
            $table->increments('idLog')->nullable(false);
            $table->string('event', 255)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
        });

        Schema::create('log_Tran', function (Blueprint $table) {
            $table->increments('idLog')->nullable(false);
            $table->string('event', 255)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
        });

        Schema::create('log_Error', function (Blueprint $table) {
            $table->increments('idLog')->nullable(false);
            $table->string('event', 255)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
        });

        Schema::create('mst_User', function (Blueprint $table) {
            $table->increments('idUser')->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->string('mothers_last_name', 255)->nullable();
            $table->string('password', 100)->nullable(false);
            $table->string('email', 50)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated')->nullable();
            $table->boolean('status')->default(1);
        });

        Schema::create('mst_Roles', function (Blueprint $table) {
            $table->increments('idRole')->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated')->nullable();
            $table->boolean('status')->nullable(false)->default(1);
            
            $table->foreign('idRole')->references('idUser')->on('mst_User');
        });

        Schema::create('mst_Surveys', function (Blueprint $table) {
            $table->increments('idSurvey')->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->string('welcome_text', 255)->nullable();
            $table->string('finish_text', 255)->nullable();
            $table->boolean('anon')->nullable(false)->default(0);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated')->nullable();
            $table->boolean('status')->default(1);
        });

        Schema::create('cat_SurveyType', function (Blueprint $table) {
            $table->increments('idSurveyType')->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated')->nullable();
            $table->boolean('status')->default(1);
            
            $table->foreign('idSurveyType')->references('idSurvey')->on('mst_Surveys');
        });

        Schema::create('mst_Questions', function (Blueprint $table) {
            $table->increments('idQuestion')->nullable(false);
            $table->string('question', 255)->nullable(false);
            $table->boolean('required')->nullable(false)->default(0);
            $table->integer('idSurvey')->unsigned()->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated')->nullable();
            $table->boolean('status')->default(1);
            
            $table->foreign('idSurvey')->references('idSurvey')->on('mst_Surveys');
        });
        
        Schema::create('cat_AnswerType', function (Blueprint $table) {
            $table->increments('idAnswerType')->nullable(false);
            $table->string('name', 45)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated')->nullable();
            $table->boolean('status')->default(1);
        });

        Schema::create('mst_QuestionAnswers', function (Blueprint $table) {
            $table->increments('idQuestionAnswer')->nullable(false);
            $table->string('answer', 255)->nullable(false);
            $table->integer('idQuestion')->unsigned()->nullable(false);
            $table->integer('idAnswerType')->unsigned()->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            $table->integer('updated_by')->nullable();
            $table->timestamp('updated')->nullable();
            $table->boolean('status')->default(1);
            
            $table->foreign('idQuestion')->references('idQuestion')->on('mst_Questions');
            $table->foreign('idAnswerType')->references('idAnswerType')->on('cat_AnswerType');
        });

        Schema::create('mst_SurveyApplied', function (Blueprint $table) {
            $table->increments('idSurveyApplied')->nullable(false);
            $table->integer('idSurveySubject')->nullable();
            $table->integer('idSurvey')->unsigned()->nullable(false);
            $table->boolean('completed')->default(0);
            $table->timestamp('creation')->nullable(false);
            
            $table->foreign('idSurvey')->references('idSurvey')->on('mst_Surveys');
        });

        Schema::create('mst_AsnwerSurvey', function (Blueprint $table) {
            $table->increments('idAnswerSurvey')->nullable(false);
            $table->string('answer')->nullable();
            $table->integer('idQuestion')->unsigned()->nullable(false);
            $table->integer('idQuestionAnswer')->nullable();
            $table->integer('idSurveyApplied')->unsigned()->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
            
            $table->foreign('idQuestion')->references('idQuestion')->on('mst_Questions');
            $table->foreign('idSurveyApplied')->references('idSurveyApplied')->on('mst_SurveyApplied');
        });

        Schema::create('mst_SurveySubject', function (Blueprint $table) {
            $table->increments('idSurveySubject')->nullable(false);
            $table->string('name', 45)->nullable(false);
            $table->string('last_name', 45)->nullable(false);
            $table->string('mothers_last_name', 45)->nullable();
            $table->date('birthday')->nullable(false);
            $table->string('addres')->nullable(false);
            $table->string('telephone')->nullable(false);
            $table->timestamp('creation')->nullable(false);
            $table->integer('created_by')->nullable(false);
        });

        /*      ---- Product Catalog Tables ----        */

        Schema::create('cat_CatProduct', function (Blueprint $table) {
            $table->increments('idCatProduct')->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->integer('parent_id')->nullable(false);
            $table->boolean('status')->nullable(false)->default(1);
            
        });
        
        Schema::create('cat_Products', function (Blueprint $table) {
            $table->increments('idProduct')         ->nullable(false);
            $table->integer('idCatProduct')         ->nullable(false)->unsigned();
            $table->string('name', 255)             ->nullable(false);
            $table->string('description', 255)      ->nullable();
            $table->string('material', 255)         ->nullable(false);
            $table->string('sku', 255)              ->nullable(false);
            $table->string('features', 255)         ->nullable(false);
            $table->string('description_accesories')->nullable(false);
            $table->string('comments')              ->nullable();
            $table->timestamp('creation')           ->nullable(false);
            $table->integer('created_by')           ->nullable(false);
            $table->integer('updated_by')           ->nullable();
            $table->timestamp('updated')            ->nullable();
            $table->boolean('status')               ->default(1);
            
            $table->foreign('idCatProduct')->references('idCatProduct')->on('cat_CatProduct');
        });

        Schema::create('mst_ProdVar', function (Blueprint $table) {
            $table->increments('idProdVar')->nullable(false);
            $table->string('var_name')->nullable(false);
            $table->integer('idProduct')->unsigned()->nullable(false);
            
            $table->foreign('idProduct')->references('idProduct')->on('cat_Products');
        });

        Schema::create('mst_CatProdMedia', function (Blueprint $table) {
            $table->increments('idMedia')->nullable(false);
            $table->integer('idCatProduct')->unsigned()->nullable(false);
            $table->string('path', 255)->nullable(false);
            $table->timestamp('creation')->nullable(false);
            
            $table->foreign('idCatProduct')->references('idCatProduct')->on('cat_CatProduct');
        });
        
        Schema::create('mst_Media', function (Blueprint $table) {
            $table->increments('idMedia')   ->nullable(false);
            $table->integer('idProdVar')    ->nullable(false)->unsigned();
            $table->string('path', 255)     ->nullable(false);
            $table->timestamp('creation')   ->nullable(false);
            $table->integer('created_by')   ->nullable(false);
            $table->string('ext', 10)       ->nullable(false);
            
            $table->foreign('idProdVar')->references('idProdVar')->on('mst_ProdVar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        /*      --- Survey System ---       */
        if (Schema::hasTable('mst_Roles')) 
            Schema::drop('mst_Roles');
        if (Schema::hasTable('mst_User')) 
            Schema::drop('mst_User');        
        if (Schema::hasTable('log_Tran')) 
            Schema::drop('log_Tran');
        if (Schema::hasTable('log_Session')) 
            Schema::drop('log_Session');
        if (Schema::hasTable('log_Error')) 
            Schema::drop('log_Error');
        if (Schema::hasTable('mst_SurveySubject')) 
            Schema::drop('mst_SurveySubject');
        if (Schema::hasTable('mst_AsnwerSurvey')) 
            Schema::drop('mst_AsnwerSurvey');
        if (Schema::hasTable('mst_SurveyApplied')) 
            Schema::drop('mst_SurveyApplied');
        if (Schema::hasTable('mst_QuestionAnswers')) 
            Schema::drop('mst_QuestionAnswers');
        if (Schema::hasTable('cat_AnswerType')) 
            Schema::drop('cat_AnswerType');
        if (Schema::hasTable('cat_SurveyType')) 
            Schema::drop('cat_SurveyType');
        if (Schema::hasTable('mst_Questions')) 
            Schema::drop('mst_Questions');
        if (Schema::hasTable('mst_Surveys')) 
            Schema::drop('mst_Surveys');


        /*      --- Survey System ---       */
        if (Schema::hasTable('mst_Media')) 
            Schema::drop('mst_Media');
        if (Schema::hasTable('mst_CatProdMedia')) 
            Schema::drop('mst_CatProdMedia');
        if (Schema::hasTable('mst_ProdVar')) 
            Schema::drop('mst_ProdVar');
        if (Schema::hasTable('cat_Products')) 
            Schema::drop('cat_Products');
        if (Schema::hasTable('cat_CatProduct')) 
            Schema::drop('cat_CatProduct');      
    }

}
