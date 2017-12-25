<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Channels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channels-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
