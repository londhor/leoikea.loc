<?php

namespace backend\controllers;

use backend\forms\PriceForm;
use yii;
use backend\components\Controller;

/**
 * Class PriceController
 * @package backend\controllers
 */
class PriceController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new PriceForm();

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