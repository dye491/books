<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Point */
/* @var $dataProvider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Точки обмена', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="point-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--<p>
        <? /*= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) */ ?>
        <? /*= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ]) */ ?>
    </p>-->

    <!--    --><? /*= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'title',
            'address',
            'desc',
        ],
    ]) */ ?>
    <h3>Адрес: <?= $model->address ?></h3>
    <?php if ($model->desc): ?>
        <h4><?= $model->desc ?></h4>
    <?php endif; ?>

    <?php /*foreach ($model->books as $book): */ ?><!--
        <h5><? /*= Html::a(Html::encode($book->title), ['book/view', 'id' => $book->id]) */ ?></h5>
        <p>
            <? /*= $book->desc */ ?>
        </p>
    --><?php /*endforeach; */ ?>
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="btn btn-primary" style="margin: 15px auto">
            <?= Html::a('Добавить книгу',
                ['/book/create', 'point_id' => $model->id, 'user_id' => Yii::$app->user->id],
                ['class' => 'btn btn primary', 'style' => 'color: white'])
            ?>
        </div>
    <?php endif; ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions'  => ['class' => 'item'],
        'itemView'     => /*function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        }*/
            '/book/_item',
    ]) ?>

</div>
