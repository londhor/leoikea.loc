<?php

namespace backend\controllers;

use backend\forms\ContactsForm;
use yii;
use backend\components\Controller;

/**
 * Class ContactsController
 * @package backend\controllers
 */
class ContactsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new ContactsForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->store()) {
                return $this->modelSuccess([
                    'refreshAction' => ['index'],
                    'createAction' => ['index'],
                ]);
            }

            $this->modelError();
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }
}