<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Persons $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="persons-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
