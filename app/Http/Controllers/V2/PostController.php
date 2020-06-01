<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Posts;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class PostController extends ApiController
{
    const RESOURCE_PATH = 'posts';

    /**
     * Get posts by user id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function userPosts(Request $request, $id)
    {
        // Retrieve post owner by placeholder id

        $user = User::where('external_id', $id)->first();

        // If user posts are 0 retrieve and store them in database table
        if ($user->posts()->count() == 0) {
            $response = Http::get(self::BASE_PATH . self::RESOURCE_PATH . '?userId=' . $id);
            $array = $response->json();

            foreach ($array as $post) {
                Post::firstOrCreate([
                    'external_id' => $post['id']
                ],
                [
                    'external_id' => $post['id'],
                    'title' => $post['title'],
                    'body' => $post['body'],
                    'user_id' => $user->id
                ]);
            }
        }

        // Retrieve user posts
        $postQuery = $user->posts();

        // If title filter is set filter the user posts
        if ($request->input('title')) {
            $postQuery = $postQuery->where('title', 'LIKE', '%' . $request->input('title') . '%');
        }

        $posts = $postQuery->get();

        return Posts::collection($posts);
    }
}
