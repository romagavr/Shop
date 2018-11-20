<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/2/18
 * Time: 12:15 AM
 */

namespace shop\services\auth;

use Yii;
use shop\entities\User;
use shop\forms\auth\SignupForm;

class SignupService
{
    public function signup(SignupForm $form)
    {
        if (User::find()->andWhere(['username' => $form->username])->one())
        {
            throw new \DomainException('Username is already exists.');
        }
        if (User::find()->andWhere(['email' => $form->email])->one())
        {
            throw new \DomainException('Email is already exists.');
        }
        $user = User::signup($form->username, $form->email, $form->password);
        if (!$user->save()) {
            throw new \RuntimeException('Saving error!');
        }
        $sent = \Yii::$app->mailer
            ->compose(
                ['html' => 'emailConfirmToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('SignUp form for ' . Yii::$app->name)
            ->send();

        if (!$sent)
        {
            throw new \RuntimeException('Email sending error.');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }

        /* @var $user User */
        $user = User::findOne(['email_confirm_token' => $token]);

        if (!$user) {
            throw new \DomainException('User not found');
        }
        $user->confirmSignup();

        if (!$user->save())
        {
            throw new \RuntimeException('Saving error.');
        }
    }
}