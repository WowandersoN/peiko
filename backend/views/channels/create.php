<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Channels */

$this->title = Yii::t('app', 'Create Channels');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Channels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channels-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
