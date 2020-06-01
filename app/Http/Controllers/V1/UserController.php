<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    const RESOURCE_PATH = 'users';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = Http::get(self::BASE_PATH . self::RESOURCE_PATH);

        return response($response->json(), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Http::get(self::BASE_PATH . self::RESOURCE_PATH . '/' . $id);

        return response($response->json(), Response::HTTP_OK);
    }
}
