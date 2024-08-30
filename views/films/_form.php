<?php

use app\widgets\select2\Select2Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Films $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="films-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput() ?>

    <?php
    echo $form->field($model, 'filmPersons')->widget(
        Select2Widget::class,
        [
            'multiple' => true,
            'value' => $model->selectedPersons(),
            'items' => ArrayHelper::map(\app\models\Persons::find()->all(), 'id', 'fio')
        ]
    );
    ?>


    <?= $form->field($model, 'poster_id')->fileInput(['hiddenOptions' => ['value' => $model->poster_id]]) ?>
    <?php
    if ($model->poster) {
        ?>
        <img src="/<?=$model->poster->path?>" class="mb-3 img-thumbnail w-25" alt="" />
        <?php
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
