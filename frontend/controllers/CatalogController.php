<?php

namespace frontend\controllers;

use yii;
use common\models\shop\Category;
use common\models\shop\Product;
use WhichBrowser\Parser;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        $query = Product::find();

        $countQuery = clone $query;
        $pager = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $query
            ->joinWith('image')
            ->groupBy('id')
            ->orderBy(['parsed_at' => SORT_DESC, 'id' => SORT_ASC])
            ->limit($pager->limit)
            ->offset($pager->offset)
            ->all();

        return $this->render('index', [
            'products' => $products,
            'pager' => $pager,
        ]);
    }

    public function actionCategory($path)
    {
        $category = $this->findCategory($path);

        $query = Product::find()
            ->where(['category_id' => $category->id]);

        $countQuery = clone $query;
        $pager = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $query
            ->joinWith('image')
            ->groupBy('id')
            ->orderBy(['parsed_at' => SORT_DESC, 'id' => SORT_ASC])
            ->limit($pager->limit)
            ->offset($pager->offset)
            ->all();

        return $this->render('category', [
            'products' => $products,
            'pager' => $pager,
            'category' => $category,
        ]);
    }

    public function actionSearch($query)
    {
        $productsQuery = Product::find();

        $queryLen = 0;
        $words = preg_split('/[\s,\.!\?]+/iu', $query, -1, PREG_SPLIT_NO_EMPTY);
        $queryWords = [];

        foreach ($words as $word) {
            $wordLen = mb_strlen($word);
            if ($wordLen < 3) {
                continue;
            }

            $queryWords[] = mb_strtolower($word);
            $queryLen += $wordLen;
        }

        if ($queryLen >= 3) {
            foreach ($queryWords as $word) {
                $productsQuery->orFilterWhere(['like', "LOWER(CONCAT_WS(' ', title_pl, title, descr_pl, descr))", $word]);
            }
        } else {
            $productsQuery->where('0=1');
        }

        $queryArticle = preg_replace('/\D+/iu', '', $query);

        if ($queryArticle !== '') {
            $productsQuery->orFilterWhere(['like', 'id', $queryArticle]);
        }

        $countQuery = clone $productsQuery;
        $pager = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $productsQuery
            ->joinWith('image')
            ->groupBy('id')
            ->orderBy(['parsed_at' => SORT_DESC, 'id' => SORT_ASC])
            ->limit($pager->limit)
            ->offset($pager->offset)
            ->all();

        return $this->render('search', [
            'products' => $products,
            'pager' => $pager,
            'query' => $query,
        ]);
    }

    protected function findCategory($path)
    {
        $category = Category::findOne(['slug' => $path]);

        if ($category === null) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $category;
    }

    protected function getPageSize()
    {
        $detector = new Parser(Yii::$app->request->userAgent);

        if ($detector->isMobile()) {
            return 12;
        }

        return 24;
    }
}