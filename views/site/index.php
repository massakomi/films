<?php

/** @var yii\web\View $this */

/** @var app\models\FilmsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

/** @var app\models\FilmsSearch $searchModelPersons */
/** @var yii\data\ActiveDataProvider $dataProviderPersons */

$this->title = 'Films';

?>
<div class="site-index">

    <div class="text-center mt-3 mb-3">
        <h1 class="display-4">Films</h1>
    </div>

    <?php echo $this->render('@app/views/films/index_grid', compact('searchModel', 'dataProvider')); ?>

    <div class="text-center mt-3 mb-3">
        <h1 class="display-4">Actors</h1>
    </div>

    <?php echo $this->render('@app/views/persons/index_grid', [
        'searchModel' => $searchModelPersons,
        'dataProvider' => $dataProviderPersons,
    ]); ?>
</div>
