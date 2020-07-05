<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMFreeMailDomain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('m_free_mail_domain');
      
      Schema::table('m_free_mail_domain', function (Blueprint $table) {
        $sql = "
          CREATE TABLE `m_free_mail_domain` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `free_mail_domain_name` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`)
            );
          ";
        
        DB::connection()->getPdo()->exec($sql);
  
        try {
          $url = 'https://gist.githubusercontent.com/mpyw/6b59ffbe517da9cccbf40db9aa30d09b/raw/1b9a962b98b5b128a89124c6038c6fd0fbb58a5a/free_email_provider_domains.txt';
          $file = file($url);
          foreach ($file as $index => $item) {
            $str = rtrim($item);
            DB::table('m_free_mail_domain')->insert(['free_mail_domain_name' => $str]);
          }
        } catch(\Exception $e) {
          logger()->warning($e->getMessage());
        }
    
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
