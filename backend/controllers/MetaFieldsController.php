<?php

namespace backend\controllers;

use yii;
use backend\components\Controller;
use backend\forms\MetaFieldsForm;

/**
 * Class MetaFieldsController
 * @package backend\controllers
 */
class MetaFieldsController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new MetaFieldsForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->store()) {
                Yii::$app->session->setFlash('success', 'Дані оновлені');

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