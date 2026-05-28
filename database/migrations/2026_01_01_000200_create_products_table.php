<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('sku')->nullable()->unique();
            $table->string('slug')->nullable()->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image_path')->nullable();
            $table->string('image_url', 1000)->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('stock_status')->default('in_stock');
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'is_available']);
            $table->index('stock_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
