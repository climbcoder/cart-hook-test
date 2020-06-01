<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends ApiController
{
    const RESOURCE_PATH = 'comments';

    /**
     * Get comments by post id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postComments($id)
    {
        $response = Http::get(self::BASE_PATH . self::RESOURCE_PATH . '?postId=' . $id);

        return response($response->json(), Response::HTTP_OK);
    }
}
