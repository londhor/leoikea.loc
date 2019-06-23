<?php

Yii::setAlias('@metronic', dirname(__DIR__) . '/assets/metronic');

Yii::$container->set('yii\bootstrap\ActiveField', [
    'class' => 'yii\bootstrap\ActiveField',
    'options' => [
        'class' => 'form-group m-form__group',
    ],
    'inputOptions' => [
        'class' => 'form-control m-input',
    ],
    'labelOptions' => [],
    'hintOptions' => [
        'class' => 'm-form__help',
        'tag' => 'span',
    ],
    'errorOptions' => [
        'class' => 'form-control-feedback',
        'tag' => 'div',
    ],
    'horizontalCssClasses' => [
        'label' => 'col-form-label col-lg-3 col-sm-12',
        'wrapper' => 'col-lg-9 col-md-9 col-sm-12',
        'hint' => 'offset-md-3',
        'error' => 'offset-md-3',
    ]
]);

Yii::$container->set('yii\bootstrap\ActiveForm', [
    'class' => 'yii\bootstrap\ActiveForm',
    'errorCssClass' => 'has-danger',
    'options' => [
        'class' => 'm-form',
    ],
]);