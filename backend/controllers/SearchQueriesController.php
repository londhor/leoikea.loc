<?php

namespace backend\controllers;

use backend\forms\SearchQueriesForm;
use frontend\components\multilang\Languages;
use yii;
use backend\components\Controller;

/**
 * Class SearchQueriesController
 * @package backend\controllers
 */
class SearchQueriesController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new SearchQueriesForm();

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