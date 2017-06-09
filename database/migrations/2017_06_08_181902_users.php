<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_Roles', function (Blueprint $table) {
            $table->increments('id')                    ->nullable(false);
            $table->string('name', 255)                 ->unique()->nullable(false);
            $table->timestamp('created_at')             ->nullable(false);
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->timestamp('updated_at')             ->nullable();
            $table->boolean('status')->nullable(false)  ->default(1);
            
        });      
        
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idRole')                   ->unsigned()->nullable();
            $table->string('name')                      ->nulable(false);
            $table->string('email')                     ->unique();
            $table->string('password')                  ->nullable(false);
            $table->string('offline')                   ->nullable();
            $table->string('last_name', 255)            ->nullable();
            $table->string('mothers_last_name', 255)    ->nullable();
            $table->string('address')                   ->nullable();
            $table->string('mobile_phone')              ->nullable();
            $table->integer('created_by')               ->nullable();
            $table->integer('updated_by')               ->nullable();
            $table->boolean('status')                   ->default(1);
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('idRole')->references('id')->on('mst_Roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');            
        Schema::dropIfExists('mst_Roles');
    }
}
