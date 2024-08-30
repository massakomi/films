<?php

use app\models\Persons;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PersonsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'fio',
        [
            'class' => ActionColumn::class,
            'urlCreator' => function ($action, Persons $model, $key, $index, $column) {
                return Url::toRoute(["persons/$action", 'id' => $model->id]);
            },
            'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}{link}'
        ],
    ]
]); ?>
