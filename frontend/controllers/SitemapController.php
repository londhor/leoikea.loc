<?php

namespace frontend\controllers;

use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\shop\Product;

/**
 * Controller for articles
 *
 * @package frontend\controllers
 */
class SitemapController extends Controller
{
    /**
     * View single article action
     *
     * @param string $key
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {

////////////////////////////////////////////////////////////////////

        //$metaFieldsSettings = Yii::$app->metaFieldsSettings;
        //$metaFieldsSettings->generateForCatalog();

        $products = Product::find();

        $products = $products
            // ->with('image')
            ->select(['id','title', 'descr','price'])
            ->orderBy(['parsed_at' => SORT_DESC])
            ->limit(100)
            ->AsArray()
            //->offset($pager->offset)
            ->all();
///////////////////////////////////////////////////////////////////
// print_r($products);
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
echo '<xml>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

foreach ($products as $product) {
    print_r('<someine>');
    print_r('<url>');
        print_r('<loc>');
            echo "//".$_SERVER['HTTP_HOST']."/product/{$product['id']}";
        print_r('</loc>');
        print_r('<image:image>');
            print_r('<image:loc>');
                echo "https://".$_SERVER['HTTP_HOST']."/product/{$product['image']['path']}";
            print_r('</image:loc>');
        print_r('</image:image>');
    print_r('</url>');
    print_r('</someine>');
}

echo '</urlset>';
echo '</xml>';










        // return $this->render('index', [
        //     'article' => 'asdads',
        // ]);

    }

    public function actionTest()
    {

        return 'TEST';
    }
}