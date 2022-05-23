<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunity_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opportunity_id')
                ->constrained('opportunity')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product_id')->constrained('product');
            $table->decimal('sale_quantity', 15, 4);
            $table->decimal('sale_price', 15, 4)->nullable();
            $table->decimal('sale_amount', 15, 4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opportunity_product');
    }
};
