<?php

namespace console\controllers;

use backend\models\Manager;
use yii;
use yii\helpers\Console;

/**
 * Class ManagerController
 * @package app\commands
 */
class ManagerController extends yii\console\Controller
{
    public function actionCreate()
    {
        echo 'Create manager: ' . PHP_EOL;

        $name = Console::prompt('Name:', [
            'required' => true,
            'pattern' => '/^[\w\s\d\-_]+$/iu',
        ]);

        $emailValidator = new yii\validators\EmailValidator();
        $email = Console::prompt('Email:', [
            'required' => true,
            'validator' => [$emailValidator, 'validate'],
        ]);

        $password = Console::prompt('Password:', [
            'required' => true,
            'pattern' => '/^.{4,}$/iu',
            'error' => 'Min password length: 4',
        ]);

        $manager = new Manager();
        $manager->email = $email;
        $manager->name = $name;
        $manager->setPassword($password);
        $manager->generateAuthKey();

        if (!$manager->save()) {
            echo 'Error on Insert manager' . PHP_EOL;
        } else {
            echo 'Success' . PHP_EOL;
            echo 'ManagerID: ' . $manager->id . PHP_EOL;
        }

        return 0;
    }
}