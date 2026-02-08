<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('movie_user_list', function (Blueprint $table) {
            $table->string('poster_path')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('movie_user_list', function (Blueprint $table) {
            $table->dropColumn('poster_path');
        });
    }
};
