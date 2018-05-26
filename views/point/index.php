<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Точки обмена';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="point-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?/*= Html::a('Create Point', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => /*function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
        }*/'_item',
    ]) ?>
    <?php Pjax::end(); ?>
</div>
