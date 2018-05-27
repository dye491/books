<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $model->point->title, 'url' => ['/point/view', 'id' => $model->point_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'title',
            'author',
            'desc',
            'issueYear',
            'point_id',
            'user_id',
            'status',
            'rating',
            'imagePath',
        ],
    ]) ?>
    <div class="field-group">
        <?= Html::a($model->status ? 'Вернуть эту книгу' : 'Взять эту книгу',
            [$model->status ? '/book/free' : '/book/take', 'id' => $model->id],
            ['class' => 'btn btn-primary']) ?>
    </div>

</div>
