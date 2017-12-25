<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'parser' => [
            'class' => \backend\components\Parser::class,
        ]
    ],
    'modules'    => [
        'utility' => [
            'class' => 'c006\utility\migration\Module',
        ],
    ],
];
