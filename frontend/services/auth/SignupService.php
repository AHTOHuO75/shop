<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/29/17
 * Time: 10:33 PM
 */

namespace frontend\services\auth;


use common\entities\User;
use common\repositories\UserRepository;
use frontend\forms\SignupForm;
use yii\debug\models\search\UserSearchInterface;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;
    /**
     * @var UserRepository
     */
    private $users;


    public function __construct(MailerInterface $mailer, UserRepository $users)
    {
        $this->mailer = $mailer;
        $this->users = $users;
    }


    public function signup(SignupForm $form): void
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->users->save($user);

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
        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }

}




