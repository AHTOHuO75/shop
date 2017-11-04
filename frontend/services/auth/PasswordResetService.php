<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/30/17
 * Time: 10:11 PM
 */

namespace frontend\services\auth;


use frontend\forms\{
    PasswordResetRequestForm, ResetPasswordForm
};
use common\entities\User;
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
     * PasswordResetService constructor.
     * @param $supportEmail
     * @param MailerInterface $mailer
     */
    public function __construct($supportEmail, MailerInterface $mailer)
    {
        /** @var TYPE_NAME $this */
        $this->supportEmail=$supportEmail;
        $this->mailer = $mailer;
    }

    /**
     * @param PasswordResetRequestForm $form
     */
    public function request(PasswordResetRequestForm $form): void
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException('User is not found');
        }

        $user->requestPasswordReset();

        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }

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
        if (!User::findByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = User::findByPasswordResetToken($token);

        if (!$user) {
            throw new \DomainException('User is not found');
        }

        $user->resetPassword($form->password);

        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }
    }


}