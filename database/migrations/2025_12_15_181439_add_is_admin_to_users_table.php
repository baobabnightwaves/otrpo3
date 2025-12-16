<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsAdminToUsersTable extends Migration
{
    public function up()
    {
        // Добавляем поле is_admin в таблицу users
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });

        // Добавляем поле user_id в таблицу sharks (или вашу таблицу из ЛР3)
        Schema::table('sharks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sharks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
}
