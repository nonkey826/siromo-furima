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
        Schema::create('addresses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('zipcode')->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
