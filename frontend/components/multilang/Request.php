<?php

namespace frontend\components\multilang;

use yii;
use yii\base\InvalidConfigException;

/**
 * Is Request class complements base webRequest
 * and can detect user language from url
 * @inheritDoc
 * @package frontend\components\multilang
 */
class Request extends yii\web\Request
{
    /**
     * @var Languages
     */
    protected $languagesComponent;
    /**
     * @var string|null
     */
    private $_pathInfo;
    /**
     * @var string|null
     */
    private $_languageUrl;

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
     */
    public function getPathInfo()
    {
        if ($this->_pathInfo === null) {
            $beforeUrl = $this->getUrl();
            $languageUrl = $this->getLanguageUrl();

            $this->setUrl($languageUrl);
            $this->_pathInfo = $this->resolvePathInfo();
            $this->setUrl($beforeUrl);
        }

        return $this->_pathInfo;
    }

    /**
     * @inheritDoc
     */
    public function setPathInfo($value)
    {
        $this->_pathInfo = $value === null ? null : ltrim($value, '/');
    }

    /**
     * @throws InvalidConfigException
     */
    public function getLanguageUrl()
    {
        if ($this->_languageUrl === null) {
            $this->_languageUrl = ltrim($this->getUrl(), '/');
            $parts = explode('/', $this->_languageUrl, 2);
            $languageCode = isset($parts[0]) ? $parts[0] : null;
            $language = $this->languagesComponent->get($languageCode);

            if ($language !== null) {
                $this->languagesComponent->setCurrent($language);
                Yii::$app->language = $language->getCode();
                $this->_languageUrl = isset($parts[1]) ? $parts[1] : '';
            }
        }

        return $this->_languageUrl;
    }
}