<?php

namespace backend\controllers;

use backend\forms\ContactsForm;
use frontend\components\multilang\Languages;
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

        /** @var Languages $languagesComponent */
        $languagesComponent = Yii::$app->languages;

        return $this->render('index', [
            'model' => $model,
            'languages' => $languagesComponent->getLanguages(),
        ]);
    }
}