<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->constrained('role')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('action_name', 255)->index();
            $table->string('action_group_description', 255)->index();
            $table->string('action_name_description', 255)->index();
            $table->tinyInteger('is_allowed')->nullable();
        });

        DB::table('role_permission')->insert([
            [
                'role_id' => 1,
                'action_name' => 'brand.formAccess',
                'action_group_description' => 'Marcas',
                'action_name_description' => 'Acesso ao formulário',
                'is_allowed' => 1,
            ],
            [
                'role_id' => 1,
                'action_name' => 'brand.store',
                'action_group_description' => 'Marcas',
                'action_name_description' => 'Incluir',
                'is_allowed' => 1,
            ],
            [
                'role_id' => 1,
                'action_name' => 'brand.update',
                'action_group_description' => 'Marcas',
                'action_name_description' => 'Editar',
                'is_allowed' => 0,
            ],
            [
                'role_id' => 1,
                'action_name' => 'brand.destroy',
                'action_group_description' => 'Marcas',
                'action_name_description' => 'Deletar',
                'is_allowed' => 0,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
};
