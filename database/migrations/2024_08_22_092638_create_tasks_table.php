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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->string('title')->nullable();
            $table->string('project_status')->nullable();
            $table->string('priority')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->text('description')->nullable();
            $table->string('credit_limit')->nullable();
            $table->string('billing_cycle')->nullable();
            $table->text('agreement_review')->nullable();
            $table->string('agreement_sign')->nullable();
            $table->string('technical_interconnection')->nullable();
            $table->tinyInteger('status')->default('open');
            $table->timestamps();

            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
