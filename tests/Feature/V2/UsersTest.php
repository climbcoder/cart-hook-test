<?php

namespace Tests\Feature\V2;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testUsersEndpointReturnListOfUsers()
    {
        // Check that that there aren't users in the db before first call

        $this->assertCount(0, User::all());

        $response = $this->get('api/v2/users');

        $response->assertStatus(200);

        $data = $response->json('data');

        $this->assertCount(10, $data);

        // Check that user are stored in db
        $this->assertCount(10, User::all());

        // Check that on second call doesn't create again the users
        $this->get('api/v2/users');
        $this->assertCount(10, User::all());

    }

    /**
     * @return void
     */
    public function testUsersEndpointReturnListOfUsersFilteredByEmail()
    {
        $response = $this->get('api/v2/users?email=emailThatDoesntExist');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(0, $data);


        $response = $this->get('api/v2/users?email=Sincere@april.biz');

        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertCount(1, $data);

        $user = User::where('email', 'Sincere@april.biz')->first();
        $this->assertEquals($user->email, $data[0]['email']);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUsersSpecificEndpointReturnSingleUser()
    {
        // Check that that there aren't users in the db before first call

        $this->assertCount(0, User::all());

        $response = $this->get('api/v2/users/1');
        $response->assertStatus(200);

        $data = $response->json();

        $this->assertEquals("Leanne Graham", $data['name']);
        $this->assertEquals("Sincere@april.biz", $data['email']);

        $user = User::where('external_id', 1)->first();
        $this->assertEquals($user->email, $data['email']);

        // Check that user is stored in db
        $this->assertCount(1, User::all());

        // Check that on second call doesn't create again the user
        $this->get('api/v2/users/1');
        $this->assertCount(1, User::all());
    }
}
