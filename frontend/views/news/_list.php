<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="news-item">
    <?php if($model->small_img):?>
    <?= Html::img('/uploads/small_img/' . $model->small_img, ['style' => ['width' => '70px']])?>
    <?php endif; ?>
    <h2><?= Html::a($model->short_text, \yii\helpers\Url::to(['/news/view', 'id' => $model->id]))?></h2>
    <?= HtmlPurifier::process($model->long_text ) ?>
</div>