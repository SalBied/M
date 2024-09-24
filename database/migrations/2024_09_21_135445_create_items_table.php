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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->float('price');
            $table->enum('condition', ['new', 'used']);
            $table->json('photos');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('location');
            $table->enum('status', ['active', 'sold', 'removed'])->default('active');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
