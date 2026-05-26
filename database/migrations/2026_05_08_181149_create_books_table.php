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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('title')->index();
            $table->string('author', 100)->index();
            $table->text('description');
            $table->string('cover');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->decimal('rent', 5, 2);
            $table->decimal('fine', 5, 2);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
