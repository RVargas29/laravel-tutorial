<?php

/*
 * Created with artisan with the command: php artisan make:controller PostController
 */

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Session\Store;

class PostController extends Controller
{
    public function getIndex(Store $session) {
        $post = new Post();
        $posts = $post->getPosts($session);
        return view('blog.index', ['posts' => $posts]);
    }
}
