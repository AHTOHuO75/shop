<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/29/17
 * Time: 5:56 PM
 */

namespace common\tests\unit\entities\User;

use Codeception\Test\Unit;
use common\entities\User;

class SignupTest extends Unit
{
    public function testSuccess()
    {
        $user = User::signup(
            $username = 'username',
            $email = 'email@site.com',
            $password = 'password'
        );

        $this->assertEquals($username, $user->username);
        $this->assertEquals($email, $user->email);
        $this->assertNotEmpty($user->password_hash);
        $this->assertNotEquals($password, $user->password_hash);
        $this->assertNotEmpty($user->created_at);
        $this->assertNotEmpty($user->auth_key);
        //$this->assertEquals($user->status, User::STATUS_ACTIVE);
        $this->assertTrue($user->isActive());
    }

}
