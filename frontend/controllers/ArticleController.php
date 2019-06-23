<?php

namespace frontend\controllers;

use yii;
use common\models\Article;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    public function actionView($key)
    {
        $article = $this->findArticle($key);

        if ($article->meta_title) {
            $this->view->title = $article->meta_title;
        } else {
            $this->view->title = sprintf('%s | %s', $article->title, Yii::$app->name);
        }

        if ($article->meta_description) {
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $article->meta_description,
            ]);
        }

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