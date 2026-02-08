<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('movie_user_list', function (Blueprint $table) {
            $table->string('release_date')->nullable();
            $table->string('title')->nullable();
        });
    }

    public function down()
    {
        Schema::table('movie_user_list', function (Blueprint $table) {
            $table->dropColumn(['release_date', 'title']);
        });
    }
};
