<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Article;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api']], function() {
    Route::resource('articles', 'Api\ArticlesController', ['except' => ['create', 'edit']]);

    //記事を投稿する機能
    Route::post('/article/{id}', function($id){
        //投稿するユーザーを取得
        $user = User::where('id', $id)->first();

        //リクエストデータをもとに記事を作成
        $article = new Article();
        $article->title = request('title');
        $article->content = request('content');

        //ユーザーに関連づけて保存
        $user->articles()->save($article);

        //テストのためtitle, contentのデータをリターン
        return ['title' => request('title'), 'content' => request('content')];
    });
});
