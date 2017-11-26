<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/15/17
 * Time: 4:25 PM
 */

namespace common\bootstrap;

use shop\services\auth\PasswordResetService;
use shop\services\ContactService;
use Yii;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        // TODO: Implement bootstrap() method.
        /** @var TYPE_NAME $container */
        $container = \Yii::$container;
        $container->setSingleton(MailerInterface::class,function () use ($app){
            return $app->mailer;
        });
        if (isset(Yii::$app->params['supportEmail'])) {
            $container->setSingleton(PasswordResetService::class,[],[
                [Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'],
            ]);
        }
        if (!empty(Yii::$app->params['supportEmail'])) {
            if (!empty(Yii::$app->params['adminEmail'])) {
                $container->setSingleton(ContactService::class,[],[
                [Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'],
                [Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'],
            ]);
            }
        }
    }
}