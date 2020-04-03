<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInfoToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->mediumText('about');
            $table->boolean('cars');
            $table->boolean('food');
            $table->boolean('math');
            $table->boolean('animals');
            $table->boolean('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('about');
            $table->dropColumn('cars');
            $table->dropColumn('food');
            $table->dropColumn('math');
            $table->dropColumn('animals');
            $table->dropColumn('books');
        });
    }
}
