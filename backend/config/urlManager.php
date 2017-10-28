<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/15/17
 * Time: 10:59 AM
 */
return [
    'class' => 'yii\web\UrlManager',
    /*'hostInfo' => $params['backendHostInfo'],*/
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:login|logout>' => 'site/<_a>',
        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];