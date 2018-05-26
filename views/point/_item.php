<?php
/**
 * @var $model app\models\Point
 * @var $key mixed
 * @var $index integer
 * @var $widget \yii\widgets\ListView
 */

use yii\helpers\Html;

?>
<div class="col-sm-6">
    <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id]); ?>
    <?= Html::tag('p', Html::encode($model->address)); ?>
</div>
