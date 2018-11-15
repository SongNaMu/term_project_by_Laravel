<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_id');
            $table->unsignedInteger('board_id');
            $table->text('content');
            $table->unsignedInteger('comment_id')->default(null)->nullable();
            $table->timestamp('regtime')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('board_id')->references('id')->on('boards');
            $table->foreign('comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
