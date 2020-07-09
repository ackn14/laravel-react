<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
         {
             \DB::table('posts')->insert([
                 [
                     'name' => '名前1',
                     'content' => '内容1'
                 ],
                 [
                     'name' => '名前2',
                     'content' => '内容2'
                 ],
                 [
                     'name' => '名前3',
                     'content' => '内容3'
                 ],
             ]);
         }
}
