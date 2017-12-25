<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'short_text',
            [
                'attribute' => 'long_text',
                'format'=> 'raw',
                'contentOptions' => [
                    'style' => 'max-width:200px;overflow:auto',
                ],
            ],
            [
                'attribute' => 'small_img',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::img(Yii::$app->urlManagerFrontend->baseUrl. '/uploads/small_img/'. $data['small_img'], ['width' => '70px']);
                },
            ],
            [
                'attribute' => 'img',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::img(Yii::$app->urlManagerFrontend->baseUrl. '/uploads/img/'. $data['small_img'], ['width' => '70px']);
                },
            ],
            'type',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
