<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'long_text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'small_img')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ]
    ]); ?>

    <?= $form->field($model, 'img')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
            'showPreview' => false,
            'showCaption' => true,
            'showRemove' => true,
            'showUpload' => false
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
