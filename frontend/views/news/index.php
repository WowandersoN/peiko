<?php

use common\models\News;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

$dataProvider = new ActiveDataProvider([
    'query' => News::find()->orderBy('created_at DESC'),
    'pagination' => [
        'pageSize' => 20,
    ],
]);

echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
    'layout' => "{pager}\n{items}\n{pager}",
    'pager' => [
        'firstPageLabel' => 'Первая',
        'lastPageLabel' => 'Последняя',
        'nextPageLabel' => 'Следующая',
        'prevPageLabel' => 'Предыдущая',
        'maxButtonCount' => 5,
    ],
]);