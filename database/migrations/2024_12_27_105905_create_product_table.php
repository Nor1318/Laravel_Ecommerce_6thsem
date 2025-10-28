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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('detail')->nullable();
            $table->decimal('cost', 8, 2);
            $table->unsignedBigInteger('cat_id');
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Y', 'N'])->default('Y');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
