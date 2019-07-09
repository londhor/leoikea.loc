<?php

namespace frontend\controllers;

use frontend\components\MetaFieldsSettings;
use yii;
use common\models\shop\Category;
use common\models\shop\Product;
use WhichBrowser\Parser;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        /** @var MetaFieldsSettings $metaFieldsSettings */
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForCatalog();

        $categories = Category::find()
            ->where(['is', 'parent_id', new yii\db\Expression('NULL')])
            ->all();

        $query = Product::find();

        $countQuery = clone $query;
        $pager = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $query
            ->with('image')
            ->orderBy(['parsed_at' => SORT_DESC, 'id' => SORT_ASC])
            ->limit($pager->limit)
            ->offset($pager->offset)
            ->all();

        return $this->render('index', [
            'products' => $products,
            'pager' => $pager,
            'categories' => $categories,
        ]);
    }

    public function actionCategory($path)
    {
        $category = $this->findCategory($path);

        /** @var MetaFieldsSettings $metaFieldsSettings */
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForCategory($category);

        $subCategories = $category->subCategories;
        $categories = ArrayHelper::merge([$category->id], ArrayHelper::getColumn($subCategories, 'id'));

        $query = Product::find()
            ->where(['category_id' => $categories]);

        $countQuery = clone $query;
        $pager = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $query
            ->with('image')
            ->orderBy(['parsed_at' => SORT_DESC, 'id' => SORT_ASC])
            ->limit($pager->limit)
            ->offset($pager->offset)
            ->all();

        return $this->render('category', [
            'products' => $products,
            'pager' => $pager,
            'category' => $category,
            'subCategories' => $subCategories,
        ]);
    }

    public function actionSearch($query)
    {
        /** @var MetaFieldsSettings $metaFieldsSettings */
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForSearch($query);

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
                $productsQuery->orFilterWhere(['or',
                    ['like', "LOWER(CONCAT_WS(' ', title, title_ru, title_pl))", $word],
                    ['regexp', "LOWER(CONCAT_WS(' ', descr, descr_ru, descr_pl))", '[[:<:]]' . $word . '[[:>:]]'],
                ]);
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
            ->with('image')
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
