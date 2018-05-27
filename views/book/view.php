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
    <div class="col-xs-2 col-xs-offset-10"
         style="width: 80px; height: 80px; background-color:<?= $model->status ? 'red' : 'green' ?>;border-radius: 50%;padding: 30px 8px;color: white;position: relative;top: -55px">
        <?= $model->status ? 'На руках' : 'Свободна' ?>
    </div>

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

    <div class="row">
        <div class="col-sm-4">

            <img src="/image/get?path=<?= $model->imagePath ?>" width="100%" height="100%"
                 alt="<?= $model->imagePath ?>">
        </div>
        <div class="col-sm-8">
            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'title',
                    'author',
                    'desc',
                    'issueYear',
                    [
                        'label' => 'Точка обмена',
                        'value' => function ($model, $widget) {
                            return $model->point->address;
                        },
                    ],
                    [
                        'attribute' => 'status',
                        'value'     => function ($model) {
                            return $model->status ? 'На руках' : 'Свободна';
                        },
                    ],
                    'rating',
                ],
            ]) ?>
        </div>
    </div>
    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="field-group">
            <?= Html::a($model->status ? 'Вернуть эту книгу' : 'Взять эту книгу',
                [$model->status ? '/book/free' : '/book/take', 'id' => $model->id],
                ['class' => 'btn btn-primary']) ?>
        </div>
    <?php endif; ?>

</div>
