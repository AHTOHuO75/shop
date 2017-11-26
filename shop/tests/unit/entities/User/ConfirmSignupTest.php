<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/13/17
 * Time: 7:37 PM
 */

namespace shop\tests\unit\entities\User;


use shop\entities\User;
use Codeception\Test\Unit;

class ConfirmSignupTest extends Unit
{
    public function testSuccess()
    {
        $user = new User(
            [
                'status' => User::STATUS_WAIT,
                'email_confirm_token' => 'token',
            ]
        );

        $user->confirmSignup();
        $this->assertEmpty($user->email_confirm_token);
        $this->assertFalse($user->isWait());
        $this->assertTrue($user->isActive());
    }

    public function testAlreadyActive()
    {
        $user = new User(
            [
                'status' => User::STATUS_ACTIVE,
                'email_confirm_token' => null,
            ]
        );

        $this->expectExceptionMessage('User is already active');
        $user->confirmSignup();
    }
}
