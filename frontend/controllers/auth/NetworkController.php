<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/8/18
 * Time: 12:08 AM
 */

namespace frontend\controllers\auth;

use shop\services\auth\NetworkService;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;

class NetworkController extends Controller
{
    private $service;

    public function __construct(string $id, $module, NetworkService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client): void
    {
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');

        try {
            $user = $this->service->auth($network, $identity);
            Yii::$app->user->login($user, Yii::$app->params['user.rememberMeDuration']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}