<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
		$posts = Post::orderBy('created_at', 'desc')->paginate(2);
		return view('welcome')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
		if (Auth::check()) {
			$user = Auth::user();
			$post = new Post($request->all());
			$post->author_id= $user->getAuthIdentifier();
			$post->save();
			$comments = $post->comments()->orderBy('created_at', 'desc')->paginate(15);
			return view('posts.show')->withPost($post)->withComments($comments);
		}else{
			abort(403, 'Unauthorized action.');
		}
	}

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function show(Post $post) {
		$comments = $post->comments()->orderBy('created_at', 'desc')->paginate(15);
		return view('posts.show')->withPost($post)->withComments($comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post) {
        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function update(Request $request, Post $post) {
    	if (Auth::check()) {
			$user = Auth::user();
			if ($user->getAuthIdentifier() === $post->author_id){
				$post->title = $request['title'];
				$post->content = $request['content'];
				$post->save();
			}else{
				return abort(403, 'Unauthorized action.');
			}
			$comments = $post->comments()->orderBy('created_at', 'desc')->paginate(15);
			return view('posts.show', ['post' => $post, 'comments' => $comments]);
		}else{
			return abort(403, 'Unauthorized action.');
		}
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $id
	 * @return Response
	 */
    public function destroy($id) {

    	Post::findOrFail($id)->delete();

        return redirect('/posts');
    }
}
