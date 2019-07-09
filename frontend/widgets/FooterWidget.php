<?php

namespace frontend\widgets;

use frontend\components\ContentSettings;
use yii\base\Widget;
use yii;

/**
 * Footer widget
 * @package frontend\widgets
 */
class FooterWidget extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        if (!$this->showFooter()) {
            return '';
        }

        return $this->render('footer', [
            'footerArticles' => $this->articles(),
            'socialLinks' => $this->social(),
            'contacts' => $this->contacts(),
        ]);
    }

    /**
     * @return array
     */
    protected function contacts()
    {
        return [
            'addresses' => $this->contentSettings()->getAddresses(),
            'phones' => $this->contentSettings()->getPhones(),
            'emails' => $this->contentSettings()->getEmails(),
        ];
    }

    /**
     * @return array
     */
    protected function articles()
    {
        return $this->contentSettings()->getFooterArticles();
    }

    /**
     * @return array
     */
    protected function social()
    {
        return $this->contentSettings()->getSocials();
    }

    /**
     * @return bool
     */
    protected function showFooter()
    {
        if (!isset($this->view->params['hideFooter'])) {
            return true;
        }

        if ($this->view->params['hideFooter'] !== true) {
            return true;
        }

        return false;
    }

    /**
     * @return ContentSettings
     */
    protected function contentSettings()
    {
        return Yii::$app->contentSettings;
    }
}