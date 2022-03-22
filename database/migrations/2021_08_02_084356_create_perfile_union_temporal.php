<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfileUnionTemporal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            INSERT INTO `perfiles` (`id`, `codigo`, `nombre`) VALUES
            (5, 'union_temporal', 'Unión temporal')
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            DELETE FROM `perfiles`
            WHERE id = 5
        ");
    }
}
