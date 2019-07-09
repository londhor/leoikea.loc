<?php

namespace frontend\widgets;

use common\models\Reviews;
use frontend\components\ContentSettings;
use yii\base\Widget;
use yii;

class ReviewsWidget extends Widget
{
    /**
     * @var array|string
     */
    public $reviewsLink;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->reviewsLink === null) {
            /** @var ContentSettings $contentSettings */
            $contentSettings = Yii::$app->contentSettings;

            $this->reviewsLink = $contentSettings->getReviewsLink();
        }
    }

    public function run()
    {
        $reviews = Reviews::find()
            ->where(['active' => true])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        if (!$reviews) {
            return '';
        }

        return $this->render('reviews', [
            'reviews' => $reviews,
            'reviewsLink' => $this->reviewsLink,
        ]);
    }
}