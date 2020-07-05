<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('reservation', function (Blueprint $table) {
        $table->unsignedInteger('reservation_id')->autoIncrement()->comment('予約ID')	;
        $table->unsignedInteger('user_engineer_id')->comment('登録者のユーザID')	;
        $table->unsignedInteger('company_id')->comment('企業ID')	;
        $table->unsignedInteger('project_id')->nullable()->default(null)->comment('仕事ID');
        $table->date('reservation_date')->comment('予約日');
        $table->time('reservation_time')->comment('予約時間');
        $table->text('reservation_text')->comment('質問・備考');
        $table->tinyInteger('cancel_flag')->default(0)->comment('キャンセルフラグ');
        $table->text('reservation_cancel_text')->nullable()->default(null)->comment('キャンセル理由');
        $table->tinyInteger('del_flag')->default(0);
        $table->timestamp('create_date')->useCurrent();
        $table->timestamp('update_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

        $table->foreign('user_engineer_id')->references('user_engineer_id')->on('user_engineer');
        $table->foreign('company_id')->references('company_id')->on('company');
        $table->foreign('project_id')->references('project_id')->on('project');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
