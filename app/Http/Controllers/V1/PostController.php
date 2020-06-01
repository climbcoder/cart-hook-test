<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class PostController extends ApiController
{
    const RESOURCE_PATH = 'posts';

    /**
     * Get posts by user id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userPosts($id)
    {
        $response = Http::get(self::BASE_PATH . self::RESOURCE_PATH . '?userId=' . $id);

        return response($response->json(), Response::HTTP_OK);
    }
}
