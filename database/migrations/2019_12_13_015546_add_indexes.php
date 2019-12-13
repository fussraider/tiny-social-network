<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->unique(['entity', 'entity_id', 'from_user_id']);
            $table->index('from_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropIndex('user_id');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->dropIndex('user_id');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropUnique(['entity', 'entity_id', 'from_user_id']);
            $table->dropIndex('from_user_id');
        });
    }
}
