<?php

namespace backend\controllers;

use backend\forms\AdvantagesForm;
use yii;
use backend\components\Controller;

/**
 * Class AdvantagesController
 * @package backend\controllers
 */
class AdvantagesController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new AdvantagesForm();

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