<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/29/17
 * Time: 10:33 PM
 */

namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\SignupForm;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        if (!$user->save())
        {
            throw new \RuntimeException('Saving error.');
        }

        $sent = $this->mailer
            -> compose(
                ['html' => 'emailConfirmToken-html','text' => 'emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Signup confirm for' . \Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Email sending error');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }


        $user = User::findOne(['email_confirm_token' => $token]);

        if (!$user) {
            throw new \DomainException('User not found.');
        }

        $user->confirmSignup();

        if (!$user->save()) {
            throw new \DomainException('Saving error.');
        }
    }
}