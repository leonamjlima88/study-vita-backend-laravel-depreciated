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
        Schema::create('opportunity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer');
            $table->foreignId('seller_id')->constrained('seller');
            $table->tinyInteger('status')->comment('[0=normal, 1=missed, 2=expired]'); // Normal, Perdida, Vencida
            $table->tinyInteger('approval')->comment('[0=pending, 1=approved, 2=refused]'); // Pendente, Aprovada, Recusada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opportunity');
    }
};
