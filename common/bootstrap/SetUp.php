<?php

namespace common\bootstrap;

use frontend\urls\CategoryUrlRule;
use shop\readModels\Shop\CategoryReadRepository;
use shop\repositories\UserRepository;
use shop\services\auth\PasswordResetService;
use shop\services\auth\SignupService;
use shop\services\ContactService;
use yii\base\BootstrapInterface;
use yii\di\Instance;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });
        $container->setSingleton(PasswordResetService::class);
        $container->setSingleton(SignupService::class);
        $container->setSingleton(UserRepository::class);
        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail']
        ]);
        // TODO: Implement bootstrap() method.

        $container->set(CategoryUrlRule::class, [], [
            Instance::of(CategoryReadRepository::class),
            Instance::of('cache'),
        ]);
    }
}