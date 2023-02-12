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
        Schema::connection('foody_customers')->create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('order_status')->default('placed');
            $table->dateTime('order_date')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('delivery_address')->nullable();
            $table->timestamps();
        });

        Schema::connection('foody_customers')->create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('product');
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('foody_customers')->dropIfExists('order_items');
        Schema::connection('foody_customers')->dropIfExists('orders');
    }
};
