<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();          
            $table->string('codigo')->unique();
            $table->string('nombre');                                    
            $table->text('descripcion');            
            $table->string('duracion')->nullable();
            //$table->double('precio')->nullable();      
            $table->integer('certificado')->nullable();
            $table->string('slug')->nullable();                       
            $table->integer('status');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign( 'category_id' )->references( 'id' )->on( 'categories' )->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete('cascade');
            $table->unsignedBigInteger('precio_id')->nullable();
            $table->foreign( 'precio_id' )->references( 'id' )->on( 'precios' )->onDelete('set null');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->foreign( 'level_id' )->references( 'id' )->on( 'levels' )->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
