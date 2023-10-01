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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table -> text("product_name");
            $table -> text("product_quantity");
            $table -> text("product_image");
            $table -> text("product_price");
            $table -> boolean("product_delivered");
            $table -> text("customer_name");
            $table -> text("customer_number");
            $table -> text("customer_email");
            $table -> text("customer_location");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
