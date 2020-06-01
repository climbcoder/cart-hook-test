<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Users;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    const RESOURCE_PATH = 'users';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        // If there are no users in database, store them

        if (User::count() < 10) {
            $response = Http::get(self::BASE_PATH . self::RESOURCE_PATH);
            $array = $response->json();

            foreach ($array as $user) {
                User::firstOrCreate([
                    'external_id' => $user['id']
                ],
                [
                    'external_id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => bcrypt(Str::random())
                ]);
            }
        }

        // If there is email filter, filter user by email

        if ($request->input('email')) {
            $users = User::where('email', $request->input('email'))->get();
        } else {
            $users = User::all();
        }

        return Users::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        // Check if user is present in db by external id and store it in db otherwise

        $user = User::where('external_id', $id)->first();

        if (!$user) {
            $response = Http::get(self::BASE_PATH . self::RESOURCE_PATH . '/' . $id);
            $array = $response->json();

            $user = User::create([
                'external_id' => $array['id'],
                'name' => $array['name'],
                'email' => $array['email'],
                'password' => bcrypt(Str::random())
            ]);
        }

        return response(new Users($user), Response::HTTP_OK);
    }
}
