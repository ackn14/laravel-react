<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBusinessTalkStatusAddColumnsPriorityColorLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_talk_status', function (Blueprint $table) {
            $table->string('color_label', 255)->nullable()->default(NULL)->after('note')->comment('色ラベル');
            $table->tinyInteger('priority')->nullable()->default(0)->after('color_label')->comment('優先度');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
