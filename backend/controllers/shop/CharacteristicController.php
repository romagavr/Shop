<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 11/13/18
 * Time: 9:05 PM
 */

namespace backend\controllers\shop;


use backend\forms\Shop\CharacteristicSearch;
use shop\entities\Shop\Characteristic;
use shop\forms\manage\Shop\CharacteristicForm;
use shop\services\manage\Shop\CharacteristicManageService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class CharacteristicController extends Controller
{
    private $service;

    public function __construct($id, $module, CharacteristicManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CharacteristicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'characteristic' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new CharacteristicForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $characteristic = $this->service->create($form);
                return $this->redirect(['view', 'id' => $characteristic->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $characteristic = $this->findModel($id);
        $form = new CharacteristicForm($characteristic);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($characteristic->id, $form);
                return $this->redirect(['view', 'id' => $characteristic->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }
        return $this->render('update', [
            'model' => $form,
            'characteristic' => $characteristic,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**
     * @param integer $id
     * @return Characteristic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Characteristic
    {
        if (($model = Characteristic::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}