<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForumAddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id');
            $table->foreign('cat_id')->references('id')->on('cats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forums', function (Blueprint $table) {
            $table->dropColumn(['cat_id']);
        });
    }
}
