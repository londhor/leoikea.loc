<?php

namespace frontend\components\multilang;

use yii\base\BaseObject;

/**
 * Language model for Languages component
 * @package frontend\components\multilang
 */
class Language extends BaseObject implements LanguageInterface
{
    /**
     * @var string
     */
    public $code;
    /**
     * @var string
     */
    public $urlCode;
    /**
     * @var string
     */
    public $databaseCode;
    /**
     * @var string
     */
    public $nativeName;
    /**
     * @var string
     */
    public $flag;
    /**
     * @var bool
     */
    public $current = false;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUrlCode()
    {
        return $this->urlCode;
    }

    /**
     * @return string
     */
    public function getDatabaseCode()
    {
        return $this->databaseCode;
    }

    /**
     * @return string
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @return string
     */
    public function getNativeName()
    {
        return $this->nativeName;
    }

    /**
     * @inheritDoc
     * @param bool|null $current
     * @return bool
     */
    public function isCurrent($current = null)
    {
        if ($current !== null) {
            $this->current = $current;
        }

        return $this->current === true;
    }
}