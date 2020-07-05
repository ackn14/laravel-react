<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMessageDetailAddColoumFilePath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
      Schema::table('message_detail', function (Blueprint $table) {
        $table->string('original_file_name',255)->after('message')->default(null)->nullable()->comment('オリジナルファイル名');
        $table->string('file_name',255)->after('original_file_name')->default(null)->nullable()->comment('添付ファイル名');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('message_detail', function (Blueprint $table) {
        $table->dropColumn('original_file_name');
        $table->dropColumn('file_name');
      });

    }
}
