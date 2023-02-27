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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id');
            $table->timestamps();

            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products');

            $table
                ->foreign('variant_id')
                ->references('id')
                ->on('variants');

            // We should restrict product-variant combination to have only one price per variant
            $table->unique(['product_id', 'variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
