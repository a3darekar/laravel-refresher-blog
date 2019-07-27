<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersRequest;
use App\User;
use Illuminate\View\View;

class UsersController extends Controller
{
	/**
	 * Display the specified resource.
	 * @param User $user
	 * @return View
	 */
	public function show(User $user) {
		$posts = $user->posts()->orderBy('posted_at', 'desc')->limit(5)->get();
		$comments = $user->comments()->orderBy('posted_at', 'desc')->limit(5)->get();
		return view('users.show')->withUser($user)->withPosts($posts)->withComments($comments);
	}
}