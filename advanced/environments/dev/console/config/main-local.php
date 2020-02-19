<?php
return [
    'bootstrap' => ['gii'],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'ajax-modal' => '@vendor/dchaofei/yii2-ajaxmodal/gii-template/curd/default',
                ]
            ]
        ],
    ],
];
