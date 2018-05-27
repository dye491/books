<?php
/**
 * @var $model \app\models\Book
 * @var $key mixed
 * @var $index integer
 * @var $widget \yii\widgets\ListView
 */

use yii\helpers\Html;

?>
<div>
    <img src="/image/get?path=<?= $model->imagePath ?>" width="50px" height="50px" alt="no_image" style="float: left">
    <?= Html::a(Html::encode($model->title), ['/book/view', 'id' => $model->id]) ?>
    <?= Html::tag('p', $model->desc) ?>
</div>
