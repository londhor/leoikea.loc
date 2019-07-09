<?php

namespace backend\controllers;

use yii;
use common\models\Reviews;
use backend\components\Controller;

/**
 * Class ReviewsController
 * @package backend\controllers
 */
class ReviewsController extends Controller
{
    public function actions()
    {
        return [
            'list' => [
                'class'   => \metronic\DataTablesAction::class,
                'query'   => Reviews::find(),
                'defaultOrder' => ['sort_order' => SORT_ASC],
                'columns' => [
                    'Image'     => [
                        'queryAlias' => 'image',
                        'modelAlias' => 'imageUrl',
                        'searchable' => false,
                    ],
                    'Id'        => [
                        'modelAlias'     => 'id',
                        'searchTemplate' => '={query}',
                    ],
                    'Active'    => [
                        'modelAlias'     => 'active',
                        'searchTemplate' => '={query}',
                    ],
                    'SortOrder' => [
                        'modelAlias' => 'sort_order',
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
            $model = new Reviews();
        } else {
            $model = $this->findReviews($id);
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->modelSuccess([
                    'refreshAction' => ['update', 'id' => $model->id]
                ]);
            }

            $this->modelError();
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return yii\web\Response
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $model = $this->findReviews($id);
        $model->delete();
        Yii::$app->session->addFlash('success', 'Відгук видален');

        return $this->previous('index');
    }

    /**
     * @param int $id
     * @return Reviews|null
     * @throws yii\web\NotFoundHttpException
     */
    private function findReviews($id)
    {
        if (($model = Reviews::findOne(['id' => (int) $id])) === null) {
            throw new yii\web\NotFoundHttpException('Сторінку не знайдено');
        }

        return $model;
    }
}