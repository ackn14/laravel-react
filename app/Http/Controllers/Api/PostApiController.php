<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostApiController extends Controller
{
    //
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, 200);
    }

}
