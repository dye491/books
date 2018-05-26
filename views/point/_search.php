<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PointSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="point-search">

    <?php $form = ActiveForm::begin([
        'action'  => ['index'],
        'method'  => 'get',
        'options' => [
            'data-pjax' => 1,
            'class'     => 'form-inline',
        ],
    ]); ?>

    <!--    --><? //= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'address') ?>

    <!--    --><? //= $form->field($model, 'desc') ?>

    <div class="form-group" style="position: relative; top: -6px">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить фильтр', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
