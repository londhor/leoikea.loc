<?php

namespace backend\controllers;

use backend\forms\BannerForm;
use frontend\components\multilang\Languages;
use yii;
use backend\components\Controller;

/**
 * Class BannerController
 * @package backend\controllers
 */
class BannerController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new BannerForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->store()) {
                return $this->modelSuccess([
                    'refreshAction' => ['index'],
                    'createAction' => ['index'],
                ]);
            }

            $this->modelError();
        }

        /** @var Languages $languagesComponent */
        $languagesComponent = Yii::$app->languages;

        return $this->render('index', [
            'model' => $model,
            'languages' => $languagesComponent->getLanguages(),
        ]);
    }
}