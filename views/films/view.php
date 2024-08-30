<?php

use app\models\Files;
use app\models\Films;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Films $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Films', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="films-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest) { ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'year',
            'description:ntext',
            'isbn',
            [
                'attribute' => 'poster_id',
                'label' => 'Poster',
                'format' => 'raw',
                'value' => function(Films $model) {
                    if ($model->poster) {
                        return '<img src="/'.$model->poster->path.'" class="mb-3 img-thumbnail w-25" alt="" />';
                    } else {
                        return 'No image';
                    }
                }
            ],
            'date_added',
        ],
    ]) ?>

</div>
