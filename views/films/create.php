<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Films $model */

$this->title = 'Create Films';
$this->params['breadcrumbs'][] = ['label' => 'Films', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="films-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
