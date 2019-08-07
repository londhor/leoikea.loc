<?php

namespace frontend\controllers;

use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Article;
use frontend\components\MetaFieldsSettings;

/**
 * Controller for articles
 *
 * @package frontend\controllers
 */
class BlogController extends Controller
{
    /**
     * View single article action
     *
     * @param string $key
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView()
    {

        return $this->render('index', [
            'article' => 'asdads',
        ]);
    }
}