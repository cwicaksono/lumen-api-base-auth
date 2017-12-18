<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use App\User;

class UserTest extends TestCase
{
	public function create_user()
	{
		// password key
    	// asdf = $2y$10$9YGdLfKKoL/SzQwGmGnGX.GfYz/mbO1kzG2F4QSiZChpUJrhZQ08W
    	$user = new User;
    	$user->email = 'john.doe@gmail.com';
    	$user->username = 'john.doe';
    	$user->password = '$2y$10$9YGdLfKKoL/SzQwGmGnGX.GfYz/mbO1kzG2F4QSiZChpUJrhZQ08W';
    	$user->api_token = 'c76338b4bb8e5a60020de2230b2fcabde4870a34';
    	$user->save();
	}
    // TODO - test_register_with_empty_field

    public function test_register()
    {
    	$data = array(
    		'email' => 'john.doe@gmail.com',
    		'username' => 'john.doe',
    		'password' => 'password'
    	);
    	
        $response = $this->post('/register', $data);

        $this->assertRegExp('/true/', $this->response->getContent());
    }

    public function test_login_with_empty()
    {
        $this->post('/login');

        $this->assertRegExp('/false/', $this->response->getContent());
    }

    public function test_login_with_invalid_user()
    {
    	$this->create_user();
    	
    	$data = array(
    		'email' => 'john.doe@gmail.com',
    		'password' => 'invalid'
    	);

        $this->post('/login', $data);

        $this->assertRegExp('/false/', $this->response->getContent());
    }

    public function test_login_with_valid_user()
    {
    	$this->create_user();
    	
    	$data = array(
    		'email' => 'john.doe@gmail.com',
    		'password' => 'asdf'
    	);

        $this->post('/login', $data);

        $this->assertRegExp('/true/', $this->response->getContent());
    }

    public function test_open_user_profile_without_token()
    {
    	$this->get('/user/1');

        $this->assertRegExp('/false/', $this->response->getContent());
    }

    public function test_open_user_profile_with_valid_token()
    {
    	// api_token = c76338b4bb8e5a60020de2230b2fcabde4870a34
    	// from $this->create_user() function

    	$api_token = 'c76338b4bb8e5a60020de2230b2fcabde4870a34';
    	
    	$this->create_user();

    	$this->get('/user/1?api_token='.$api_token);

        $this->assertRegExp('/true/', $this->response->getContent());
    }
    
}
