<?php

namespace frontend\controllers;

use frontend\components\MetaFieldsSettings;
use yii;
use common\models\Article;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    public function actionView($key)
    {
        $article = $this->findArticle($key);

        /** @var MetaFieldsSettings $metaFieldsSettings */
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForInformation($article);

        return $this->render('view', [
            'article' => $article
        ]);
    }

    protected function findArticle($key)
    {
        $article = Article::findOne(['slug' => $key]);

        if ($article === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $article;
    }
}