<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="news-item">
    <?php if($model->img):?>
        <?= Html::img($model->img)?>
    <?php endif; ?>
    <?= HtmlPurifier::process($model->long_text ) ?>
</div>