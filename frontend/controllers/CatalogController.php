<?php

namespace frontend\controllers;


use yii\db\Query;

use common\models\shop\ProductToCategory;
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
        $categories = false;
        //$categories = Category::find()
        //    ->where(['is', 'parent_id', new yii\db\Expression('NULL')])
        //    ->all();

        $query = Product::find();

        $countQuery = clone $query;
        $pager = new Pagination([
            'totalCount' => $countQuery->select('count(`id`)')->scalar(),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $query
            ->with('image')
            ->where(['is','deleted', NULL])
            ->orderBy(['created' => SORT_DESC])
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

        $categoriesQuery = ProductToCategory::find()
            ->select(['product_id'])
            ->where(['category_id' => $categories])
            ->all();
        $ids = [];
        foreach ($categoriesQuery as $_item) {
            $ids[] = $_item->product_id;
        }

       // exit(var_dump($ids));

            //->andWhere(['is','deleted', NULL]);
        

        //exit(var_dump($categoriesQuery));

        $query = Product::find()
            ->where(['id' => $ids]);

        $countQuery = clone $query;

        $query = $query->andWhere(['is','deleted', NULL]);

        $_totalCount = $countQuery->select('count(`id`)')->scalar();
        //$_totalCount = count($ids);
        $pager = new Pagination([
            'totalCount' => $_totalCount,
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $query
            ->with('image')
            ->andWhere(['is','deleted', NULL])
            ->select(['id','title', 'title_ru', 'title_pl', 'descr', 'descr_ru', 'descr_pl','price','old_price'])
            ->orderBy(['created' => SORT_DESC])
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

    public function actionSale()
    {
        /** @var MetaFieldsSettings $metaFieldsSettings */
        $metaFieldsSettings = Yii::$app->metaFieldsSettings;
        $metaFieldsSettings->generateForCatalog();

        $query = Product::find()
            ->where('price<old_price');

        $countQuery = clone $query;
        $pager = new Pagination([
            'totalCount' => $countQuery->select('count(`id`)')->scalar(),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        $products = $query
            ->where('price<old_price')
            ->andWhere(['is','deleted', NULL])
            ->with('image')
            ->select(['id','title', 'title_ru', 'title_pl', 'descr', 'descr_ru', 'descr_pl','price','old_price'])
            ->orderBy(['created' => SORT_DESC])
            //->limit($pager->limit)
            ->limit($this->getPageSize())
            ->offset($pager->offset)
            ->all();

        return $this->render('index', [
            'products' => $products,
            'pager' => $pager,
        ]);
    }

    public function actionSearch($query)
    {
        // $query = mb_strtolower($query);
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

        $queryArticle = preg_replace('/\D+/iu', '', $query);

        if ($queryArticle !== '') {
            $productsQuery->where(['id' => $queryArticle]);
            $productsQuery->orWhere(['id' => 'S'.$queryArticle]);
        } elseif (count($queryWords)>1) {
            $productsQuery->orFilterWhere(['or',
                ['regexp', "LOWER(CONCAT_WS(' ', descr, descr_ru, descr_pl))", '[[:<:]]' . $query . '[[:>:]]'],
            ]);
        } else {
            foreach ($queryWords as $word) {
                $word = mb_strtolower($word);
                $productsQuery->orFilterWhere(['or',
                    ['regexp', "LOWER(CONCAT_WS(' ', title, title_ru, title_pl))", $word],
                    // ['regexp', "LOWER(CONCAT_WS(' ', title, title_ru, title_pl))", $word],
                    ['regexp', "LOWER(CONCAT_WS(' ', descr, descr_ru, descr_pl))", '[[:<:]]' . $word . '[[:>:]]'],
                ]);
            }
        }

        // if ($queryArticle !== '') {
            // $productsQuery->orFilterWhere(['like', 'id', $queryArticle]);
        // }

        $pPerPage = 24;
        $pOffsetPage = $_GET['page'];
        if ($pOffsetPage>=1) {
            $pOffsetPage--;
        }
        $pOffset = $pOffsetPage*$pPerPage;

        /*
        $pCount = $productsQuery
            ->select(['id'])
            ->andWhere(['is','deleted', NULL])
            ->with('image')
            ->orderBy(['created' => SORT_DESC])
            ->all();
        */
       
        /*$pCount = $productsQuery->select('count(`id`)')
            //->andWhere(['is','deleted', NULL])
            ->scalar();*/

        // $countQuery = clone $productsQuery;
        // $pager = new Pagination([
        //     'totalCount' => $countQuery->count(),
        //     'pageSize' => $this->getPageSize(),
        //     'defaultPageSize' => $this->getPageSize(),
        // ]);


        $products = $productsQuery
            ->select(['id','title', 'title_ru', 'title_pl', 'descr', 'descr_ru', 'descr_pl','price','old_price'])
            ->with('image')
            ->andWhere(['is','deleted', NULL])
            ->orderBy(['created' => SORT_DESC])
            ->limit($pPerPage)
            ->offset($pOffset)
            ->all();


        $pager = new Pagination([
            'totalCount' => count($products),
            'pageSize' => $this->getPageSize(),
            'defaultPageSize' => $this->getPageSize(),
        ]);

        
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
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
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