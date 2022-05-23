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
        Schema::create('customer_address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->constrained('customer')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('is_default')->default(0)->comment('[0=false, 1=true]');
            $table->string('zipcode', 10)->nullable();
            $table->string('address', 100)->index();
            $table->string('address_number', 15)->nullable();
            $table->string('complement', 100)->nullable();
            $table->string('district', 100);
            $table->foreignId('city_id')->constrained('city')->onUpdate('cascade')->onDelete('cascade');
            $table->string('reference_point', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_address');
    }
};
