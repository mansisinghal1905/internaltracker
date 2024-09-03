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
        Schema::create('vendor_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('vendor_payment_id')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('payment_mode')->default('case');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('vendor_payment_id')->references('id')->on('vendor_payments')->onDelete('set null');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_payment_histories');
    }
};
