<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/9/18
 * Time: 5:45 PM
 */

namespace frontend\controllers\cabinet;

use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' =>AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}