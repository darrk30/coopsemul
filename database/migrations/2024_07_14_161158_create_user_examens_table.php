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
        Schema::create('user_examens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete('cascade');
            $table->unsignedBigInteger('exam_id');
            $table->foreign( 'exam_id' )->references( 'id' )->on( 'exams' );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_examens');
    }
};
