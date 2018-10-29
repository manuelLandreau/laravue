<?php

use App\User;
use JWTAuth;
use Tests\TestCase;

/**
 * Class MyGooderAppTest
 * Test les principales fonctionnalitées de l'appli
 */
class MyGooderAppTest extends TestCase
{
    /**
     * Test la recuperation d'un token
     */
    public function testCanGetTokenWithValidPassword()
    {
        $this->setupUser();
        $resp = $this->call(
            'POST',
            '/api/auth/login',
            ['email' => 'test@test.com', 'password' => 'test']
        );
        $data = json_decode($resp->getContent());
        $this->assertTrue($data->status == 'success', 'response was'.$resp->getContent());
    }

    /**
     * Test la non recuperation d'un token avec mauvais mot de passe
     */
    public function testCannotGetTokenWithInvalidPassword()
    {
        $this->setupUser();
        $resp = $this->call(
            'POST',
            '/api/auth/login',
            ['name' => 'test', 'password' => 'badpassword']
        );
        $data = json_decode($resp->getContent());
        $this->assertFalse(array_key_exists('token', $data), 'response was {$resp->getContent()}');
    }

    /**
     * Test une route protegée avec un header authorization
     */
    public function testCanGetProtectedAPIResourceWithTokenViaHeader()
    {
        $user = $this->setupUser();
        $token = JWTAuth::fromUser($user);
        $resp = $this->call('GET', '/api/auth/user', [], [], [], ['HTTP_AUTHORIZATION' => 'Bearer '.$token]);
        $this->assertTrue(
            $resp->getStatusCode() == 200,
            'Mauvais status: '.$resp->getStatusCode().'. '.$resp->getContent()
        );
        $data = json_decode($resp->getContent());
        $this->assertTrue(!empty($data), 'data maybe null');
    }

    /**
     * Test la recuperation des users (routes protegée) avec un header authorization
     */
    public function testCanFetchUserListWithTokenViaHeader()
    {
        $user = $this->setupUser();
        $token = JWTAuth::fromUser($user);
        $resp = $this->call('GET', '/api/users', [], [], [], ['HTTP_AUTHORIZATION' => 'Bearer '.$token]);
        $this->assertTrue(
            $resp->getStatusCode() == 200,
            'Mauvais status: '.$resp->getStatusCode().'. '.$resp->getContent()
        );
        $data = json_decode($resp->getContent());
        $this->assertTrue(!empty($data), 'data maybe null');
    }

    /**
     * Test routes protegées avec un mauvais header authorization
     */
    public function testCannotFetchUserListWithTokenViaHeader()
    {
        $resp = $this->call('GET', '/api/users', [], [], [], ['HTTP_AUTHORIZATION' => '']);
        $this->assertTrue($resp->getStatusCode() == 400,'Mauvais status: '.$resp->getStatusCode());
    }

    /**
     * Test uen routes protegée via le token en paramètre
     */
    public function testCanGetProtectedAPIResourceWithTokenViaParam()
    {
        $user = $this->setupUser();
        $token = JWTAuth::fromUser($user);
        $resp = $this->call('GET', '/api/auth/user', ['token' => $token]);
        $data = json_decode($resp->getContent());
        $this->assertTrue(!empty($data), 'data maybe null');
    }

    /**
     * Test routes protegée via mauvais token en paramètre
     */
    public function testCannotGetProtectedAPIResourceWithTokenViaParam()
    {
        $user = $this->setupUser();
        $token = JWTAuth::fromUser($user);
        $resp = $this->call('GET', '/api/auth/user', ['token' => 'bogus.bogus.bogus']);
        $this->assertTrue($resp->getStatusCode() == 400, 'Mauvais status: '.$resp->getStatusCode());
    }

    /**
     * @return User
     */
    protected function setupUser()
    {
        $user = User::where(['email' => 'test@test.com']);
        if ($user) {
            $user->delete();
        }
        $user = new User(
            [
                'name' => 'test',
                'password' => bcrypt('test'),
                'email' => 'test@test.com',
            ]
        );

        $user->save();

        return $user;
    }
}