<?php

namespace frontend\components\multilang;

use yii;
use yii\base\InvalidConfigException;

/**
 * Class UrlManager complement base UrlManager
 * and can generate url for any languages
 * @package frontend\components\multilang
 */
class UrlManager extends yii\web\UrlManager
{
    /**
     * @var Languages
     */
    protected $languagesComponent;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->languagesComponent = Yii::$app->get('languages', true);
    }

    /**
     * @inheritDoc
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        if(isset($params['language'])) {
            $language = $this->languagesComponent->get($params['language']);
            unset($params['language']);
        } else {
            $language = $this->languagesComponent->getCurrent();
        }

        $url = parent::createUrl($params);
        if ($language === null || $language->getUrlCode() === '') {
            return $url;
        }

        return '/' . $language->getUrlCode() . ($url === '/' ? '' : $url);
    }
}