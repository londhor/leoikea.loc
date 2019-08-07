<?php

namespace backend\controllers;

use frontend\components\multilang\Languages;
use yii;
use common\models\Article;
use backend\components\Controller;

/**
 * Class ArticleController
 * @package backend\controllers
 */
class ArticleController extends Controller
{
    public function actions()
    {
        return [
            'list' => [
                'class'   => \metronic\DataTablesAction::class,
                'query'   => Article::find(),
                'columns' => [
                    'Title'            => [
                        'modelAlias' => 'titleLang',
                        'queryAlias' => "CONCAT_WS(' ', title_ua, title_ru)",
                    ],
                    'Id'               => [
                        'modelAlias'     => 'id',
                        'searchTemplate' => '={query}',
                    ],
                    'Slug'               => [
                        'modelAlias'     => 'slug',
                    ],
                    'CreatedAt'             => [
                        'modelAlias'     => 'created_at',
                        'format'         => 'date',
                        'searchable'     => false,
                    ],
                    'UpdatedAt'        => [
                        'modelAlias' => 'updated_at',
                        'format'     => 'date',
                        'searchable' => false,
                    ],
                ],
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->remember();

        return $this->render('index');
    }

    /**
     * @param null $id
     * @return string
     * @throws yii\web\NotFoundHttpException
     */
    public function actionUpdate($id = null)
    {
        if ($id === null) {
            $model = new Article();
        } else {
            $model = $this->findArticle($id);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->modelSuccess([
                    'refreshAction' => ['update', 'id' => $model->id]
                ]);
            }

            $this->modelError();
        }

        /** @var Languages $languagesComponent */
        $languagesComponent = Yii::$app->languages;

        return $this->render('update', [
            'model' => $model,
            'languages' => $languagesComponent->getLanguages(),
        ]);
    }

    /**
     * @param $id
     * @return yii\web\Response
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $model = $this->findArticle($id);
        $model->delete();
        Yii::$app->session->addFlash('success', 'Стаття видалена');

        return $this->previous('index');
    }

    /**
     * @param int $id
     * @return Article|null
     * @throws yii\web\NotFoundHttpException
     */
    private function findArticle($id)
    {
        if (($model = Article::findOne(['id' => (int) $id])) === null) {
            throw new yii\web\NotFoundHttpException('Сторінку не знайдено');
        }

        return $model;
    }
}