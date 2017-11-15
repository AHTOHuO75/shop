<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/30/17
 * Time: 10:11 PM
 */

namespace frontend\services\auth;


use common\{
    repositories\UserRepository, entities\User
};
use frontend\forms\{
    PasswordResetRequestForm, ResetPasswordForm
};
use Yii;
use yii\mail\MailerInterface;

/**
 * @property  supportEmail
 */
class PasswordResetService
{
    private $supportEmail;
    private $mailer;
    /**
     * @var UserRepository
     */
    private $users;


    /**
     * PasswordResetService constructor.
     * @param $supportEmail
     * @param MailerInterface $mailer
     */
    public function __construct($supportEmail, MailerInterface $mailer, UserRepository $users)
    {
        /** @var TYPE_NAME $this */
        $this->supportEmail=$supportEmail;
        $this->mailer = $mailer;
        $this->users = $users;
    }

    /**
     * @param PasswordResetRequestForm $form
     */
    public function request(PasswordResetRequestForm $form): void
    {
        /* @var $user User */
        $user = $this->users->getByEmail($form->email);

        if (!$user->isActive()) {
            throw new \DomainException('User is not active');
        }

        $user->requestPasswordReset();

        $this->users->save($user);

        $sent = $this->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if (!$sent){
            throw new \RuntimeException('Sending error');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if ($this->users->getByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }


}