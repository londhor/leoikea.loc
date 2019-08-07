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
class ArticleController extends Controller
{
    /**
     * View single article action
     *
     * @param string $key
     * @return string
     * @throws NotFoundHttpException
     */
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

    /**
     * @param string $key
     * @return Article|null
     * @throws NotFoundHttpException
     */
    protected function findArticle($key)
    {
        $article = Article::findOne(['slug' => $key]);

        if ($article === null) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
        }

        return $article;
    }
}