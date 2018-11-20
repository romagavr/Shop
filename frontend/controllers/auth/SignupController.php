<?php

namespace frontend\controllers\auth;

use yii\web\Controller;
use shop\forms\auth\SignupForm;
use shop\services\auth\SignupService;
use yii\filters\AccessControl;
use Yii;

class SignupController extends Controller
{
    private $service;

    public function __construct($id, $module, SignupService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors() : array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->signup($form);
                Yii::$app->session->setFlash('success', 'Check your email.');
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
     */
    public function actionConfirm($token)
    {
        try{
            $this->service->confirm($token);
            Yii::$app->session->setFlash('success', 'Your email is confirmed.');
            return $this->redirect(['auth/auth/login']);
        }  catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }
}