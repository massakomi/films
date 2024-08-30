<?php

use app\models\Films;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\FilmsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'name',
        'year',
        'description:ntext',
        'isbn',
        //'poster_id',
        //'date_added',
        [
            'class' => ActionColumn::class,
            'urlCreator' => function ($action, Films $model, $key, $index, $column) {
                return Url::toRoute(["films/$action", 'id' => $model->id]);
            },
            'template' => Yii::$app->user->isGuest ? '{view}' : '{view} {update} {delete}{link}'
        ],
    ],
]); ?>