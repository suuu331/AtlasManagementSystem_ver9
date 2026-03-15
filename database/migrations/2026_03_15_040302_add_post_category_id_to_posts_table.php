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
        Schema::table('posts', function (Blueprint $table) {
            // user_idカラムの後ろに、post_category_id（数値型）を追加する
        $table->integer('post_category_id')->after('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //もし元に戻す（ロールバック）ときは、このカラムを消す
        $table->dropColumn('post_category_id');
        });
    }
};
