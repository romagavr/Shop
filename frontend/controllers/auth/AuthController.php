<?php

namespace frontend\controllers\auth;

use yii\web\Controller;
use shop\forms\auth\LoginForm;
use shop\services\auth\AuthService;
use Yii;

class AuthController extends Controller
{
    private $service;

    public function __construct(string $id, $module, AuthService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;

    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? 3600 * 24 * 30 : 0);
                return $this->goBack();
            } catch (\DomainException $e)
            {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
            return $this->render('login', [
                'model' => $form,
            ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}