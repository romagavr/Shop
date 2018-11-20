<?php

namespace frontend\controllers\auth;

use yii\web\Controller;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use shop\services\auth\PasswordResetService;
use yii\web\BadRequestHttpException;
use Yii;

class ResetController extends Controller
{
    private $service;

    public function __construct(string $id, $module, PasswordResetService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->request($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

    /**
     * @param $token
     * @return mixed
     * @throws \yii\web\BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $this->service->validateToken($token);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $form = new ResetPasswordForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->reset($token, $form);
                Yii::$app->session->setFlash('success', 'New password saved.');
                return $this->goHome();
            } catch (\DomainException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render('resetPassword', [
            'model' => $form,
        ]);
    }
}