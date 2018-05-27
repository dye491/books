<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create col-sm-6 col-sm-offset-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
