<?php

/** @var yii\web\View $this */

/** @var app\models\FilmsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

/** @var app\models\FilmsSearch $searchModelPersons */
/** @var yii\data\ActiveDataProvider $dataProviderPersons */

/** @var yii\data\ArrayDataProvider $dataProviderTop */
/** @var int $year */

use yii\bootstrap5\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

?>
<div class="site-index">

    <div class="text-center mt-3 mb-3">
        <h1 class="display-4">Top 10 actors of <?=$year?></h1>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProviderTop,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'fio',
            [
                'label' => 'Count films',
                'attribute' => 'cnt'
            ],
        ]
    ]); ?>
    <?= Html::beginForm(['/'], 'get') ?>
    <?= Html::input('number', 'year', $year, ['class' => 'form-control form-control-sm w-25 d-inline', 'max' => date('Y')]) ?>
    <?= Html::submitButton('Показать', ['class' => 'btn btn-primary btn-sm d-inline align-bottom']) ?>
    <?= Html::endForm() ?>


    <div class="text-center mt-4 mb-2">
        <h1 class="display-4">All films</h1>
    </div>

    <?php echo $this->render('@app/views/films/index_grid', compact('searchModel', 'dataProvider')); ?>

    <div class="text-center mt-4 mb-2">
        <h1 class="display-4">All actors</h1>
    </div>

    <?php echo $this->render('@app/views/persons/index_grid', [
        'searchModel' => $searchModelPersons,
        'dataProvider' => $dataProviderPersons,
    ]); ?>
</div>
