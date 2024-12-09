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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('gender')->nullable();
            $table->integer('height')->nullable();
            $table->float('weight')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('is_pregnant')->nullable();
            $table->integer('pregnancy_week')->nullable();
            $table->float('pre_pregnancy_weight')->nullable();
            $table->date('delivery_date')->nullable();
            $table->float('waist_circumference')->nullable();
            $table->float('hip_circumference')->nullable();
            $table->float('calf_circumference')->nullable();
            $table->float('thigh_circumference')->nullable();
            $table->float('bust_circumference')->nullable();
            $table->float('wrist_circumference')->nullable();
            $table->float('bicep_circumference')->nullable();
            $table->float('neck_circumference')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
