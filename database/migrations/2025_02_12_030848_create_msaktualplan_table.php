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
        Schema::create('msprojek', function (Blueprint $table) {
            $table->id('prj_id');
            $table->string('prj_id_alternative', 50)->unique();
            $table->string('prj_nama', 100);
            $table->enum('prj_jenis', ['Internal', 'Eksternal'])->default('Internal');
            $table->enum('prj_status', ['Sedang Berlangsung', 'Selesai', 'Batal'])->default('Sedang Berlangsung');
            $table->date('prj_start_date');
            $table->date('prj_deadline');
            $table->timestamps();
        });

        Schema::create('msfase', function (Blueprint $table) {
            $table->id('apf_id');
            $table->string('nama_fase');
            $table->timestamps();
        });

        Schema::create('msaktualplan', function (Blueprint $table) {
            $table->id('ap_id');
            $table->unsignedBigInteger('prj_id')->unique();
            $table->timestamps();

            $table->foreign('prj_id')->references('prj_id')->on('msprojek')->onDelete('cascade')->onUpdate('cascade');
        });

        
        Schema::create('mstask', function (Blueprint $table) {
            $table->id('tsk_id');
            $table->unsignedBigInteger('ap_id');
            $table->unsignedBigInteger('apf_id');
            $table->unsignedBigInteger('pic');
            $table->date('plan_start');
            $table->date('plan_end');
            $table->date('actual_start')->nullable();
            $table->date('actual_end')->nullable();
            $table->string('keterangan', 200)->nullable();
            $table->string('status')->default('Menunggu Dikerjakan');
            $table->timestamps();

            $table->foreign('apf_id')->references('apf_id')->on('msfase')->onDelete('cascade');
            $table->unique(['ap_id', 'apf_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('msprojek');
        Schema::dropIfExists('msfase');
        Schema::dropIfExists('msaktualplan');
        Schema::dropIfExists('mstask');
    }
};