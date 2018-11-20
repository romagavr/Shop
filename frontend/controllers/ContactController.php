<?php

namespace frontend\controllers;

use yii\web\Controller;
use shop\forms\ContactForm;
use shop\services\ContactService;
use Yii;

class ContactController extends Controller
{
    private $service;

    public function __construct(string $id, $module, ContactService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new ContactForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->send($form);
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');

            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $form,
        ]);
    }


}