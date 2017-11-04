<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/15/17
 * Time: 4:25 PM
 */

namespace common\bootstrap;

use frontend\services\auth\PasswordResetService;
use frontend\services\contact\ContactService;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Instance;
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
        $container->setSingleton(PasswordResetService::class,[],[
            [Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'],
        ]);
        $container->setSingleton(ContactService::class,[],[
        [Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'],
        [Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'],
    ]);
    }
}