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
        Schema::table('league_matches', function (Blueprint $table) {
            $table->integer('goals')->default(0);
            $table->integer('yellowcards')->default(0);
            $table->integer('redcards')->default(0);
            $table->integer('extratime')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('league_matches', function (Blueprint $table) {
            $table->dropColumn(['goals', 'yellowcards', 'redcards', 'extratime']);
        });
    }
};
