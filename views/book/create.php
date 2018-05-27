<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = ['label' => $model->point->title, 'url' => ['/point/view', 'id' => $model->point_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create col-sm-6 col-sm-offset-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
