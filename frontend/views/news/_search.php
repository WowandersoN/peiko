<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'short_text') ?>

    <?= $form->field($model, 'long_text') ?>

    <?= $form->field($model, 'small_img') ?>

    <?= $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
