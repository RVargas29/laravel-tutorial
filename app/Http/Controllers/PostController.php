<?php

/*
 * Created with artisan with the command: php artisan make:controller PostController
 */

namespace App\Http\Controllers;

use App\Post;
use App\Like;
use App\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getIndex() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(2);
        return view('blog.index', ['posts' => $posts]);
    }

    public function getAdminIndex() {
        $posts = Post::orderBy('title', 'desc')->get();
        return view('admin.index', ['posts' => $posts]);
    }

    public function getPost($id) {
        //$post = Post::where('if', $id)->first(); Lazy loading, loads likes when needed in view.
        $post = Post::where('id', $id)->with('likes')->first(); //Eager loading, loads the likes on the same query.
        return view('blog.post', ['post' => $post]);
    }

    public function getLikePost($id) {
        $post = Post::find($id);
        $like = new Like();
        $post->likes()->save($like);
        return redirect()->back();
    }

    public function getAdminCreate() {
        $tags = Tag::all();
        return view('admin.create', ['tags' =>$tags]);
    }

    public function getAdminEdit($id) {
        $tags = Tag::all();
        //$post = Post::find($id);
        $post = Post::where('id', '=', $id)->first();
        return view('admin.edit', ['post' => $post, 'postId' => $id, 'tags' =>$tags]);
    }

    public function postAdminCreate(Request $request) {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);
        $post->save(); 
        $post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));      

        return redirect()->route('admin.index')->with('info', 'Post created with title: ' . $request->input('title'));
    }

    public function postAdminEdit(Request $request) {
        $this->validate($request, [
            'title' => 'required|min:5',
            'content' => 'required|min:10'
        ]);
        $post = Post::find($request->input('id'));
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        //$post->tags()->detach();
        //$post->tags()->attach($request->input('tags') === null ? [] : $request->input('tags'));
        $post->tags()->sync($request->input('tags') === null ? [] : $request->input('tags')); 
        return redirect()->route('admin.index')->with('info', 'Post with title: ' . $request->input('title') . 'edited successfully.');
    }

    public function getAdminDelete($id) {
        $post = Post::find($id);
        $post->likes()->delete();
        $post->tags()->detach();
        $post->delete();
        //Check soft deleting at: https://laravel.com/docs/5.6/eloquent#soft-deleting
        return redirect()->route('admin.index')->with('info', 'Post deleted successfully.');
    }
}
