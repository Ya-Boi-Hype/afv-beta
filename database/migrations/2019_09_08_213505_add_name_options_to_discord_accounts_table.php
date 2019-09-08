<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameOptionsToDiscordAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discord__accounts', function (Blueprint $table) {
            $table->unsignedTinyInteger('mode')->default(0);
            $table->string('nickname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discord__accounts', function (Blueprint $table) {
            $table->dropColumn('mode');
            $table->dropColumn('nickname');
        });
    }
}
