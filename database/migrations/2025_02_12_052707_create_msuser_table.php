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
        Schema::create('mskelompok', function (Blueprint $table) {
            $table->unsignedBigInteger('kel_id')->autoIncrement();
            $table->string('kel_name');
            $table->timestamps();
        });
        
        Schema::create('msrole', function (Blueprint $table) {
            $table->unsignedBigInteger('rol_id')->autoIncrement();
            $table->string('rol_name');
            $table->timestamps();
        });
        
        Schema::create('msuser', function (Blueprint $table) {
            $table->id('usr_id');
            $table->string('usr_name')->unique();
            $table->string('usr_password');
            $table->unsignedBigInteger('kel_id');
            $table->unsignedBigInteger('rol_id');
            $table->enum('usr_status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('kel_id')
            ->references('kel_id')
            ->on('mskelompok')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->foreign('rol_id')
            ->references('rol_id')
            ->on('msrole')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }
    
    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('msuser');
        Schema::dropIfExists('msrole');
        Schema::dropIfExists('mskelompok');
    }
};