<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLikesCommentToPostGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_guests', function (Blueprint $table) {
            $table->integer('likes')->default(5);
            $table->integer('comments')->default(5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_guests', function (Blueprint $table) {
            $table->dropColumn(['likes', 'comments']);
        });
    }
}
