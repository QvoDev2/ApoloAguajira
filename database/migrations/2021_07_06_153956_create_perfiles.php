<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfiles extends Migration
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
            (2, 'ut', 'UT'),
            (3, 'unp', 'UNP')
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
            WHERE id IN (2, 3)
        ");
    }
}
