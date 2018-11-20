<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                            'attribute' => 'created_at',
                            'filter' => \kartik\date\DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'date_from',
                                    'attribute2' => 'date_to',
                                    'type' => \kartik\date\DatePicker::TYPE_RANGE,
                                    'separator' => '-',
                                    'pluginOptions' => [
                                            'todayHighlight' => true,
                                            'autoclose' => true,
                                            'format' => 'yyyy-mm-dd',
                                    ],
                            ]),
                            'format' => 'datetime',
                    ],
                    'username',
                    'email:email',
                    [
                            'attribute' => 'status',
                        'filter' => \shop\helpers\UserHelper::statusList(),
                        'value' => function (\shop\entities\User $user) {
                            return \shop\helpers\UserHelper::statusLabel($user->status);
                        },
                        'format' => 'raw',
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
