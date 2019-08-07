<?php

namespace frontend\widgets;

use common\models\shop\Category;
use frontend\components\ContentSettings;
use frontend\components\multilang\Languages;
use yii\base\Widget;
use yii;

/**
 * Header widget
 * @package frontend\widgets
 */
class HeaderWidget extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        $categories = Category::find()
            ->with('subCategories')
            ->where(['parent_id' => null])
            ->all();

        $phones = $this->contentSettings()->getPhones();
        $phone = $phones === [] ? null : reset($phones);

        return $this->render('header', [
            'categories' => $categories,
            'phone' => $phone,
            'languages' => $this->multilang()->getLanguages(),
            'currentLanguage' => $this->multilang()->getCurrent(),
        ]);
    }

    /**
     * @return ContentSettings
     */
    protected function contentSettings()
    {
        return Yii::$app->contentSettings;
    }

    /**
     * @return Languages
     */
    protected function multilang()
    {
        return Yii::$app->languages;
    }
}