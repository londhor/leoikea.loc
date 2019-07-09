<?php

namespace frontend\widgets;

use frontend\components\ContentSettings;
use yii\base\Widget;
use yii;

class AdvantagesWidget extends Widget
{
    public function run()
    {
        $advantages = $this->contentSettings()->getAdvantages();

        return $this->render('advantages', [
            'advantages' => $advantages
        ]);
    }

    /**
     * @return ContentSettings
     */
    protected function contentSettings()
    {
        return Yii::$app->contentSettings;
    }
}