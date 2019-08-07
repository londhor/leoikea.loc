<?php

namespace frontend\components\multilang;

/**
 * Interface for Language
 * @package frontend\components\multilang
 */
interface LanguageInterface
{
    /**
     * Yii2 language code
     * @return string for example ru-RU
     */
    public function getCode();
    /**
     * @return string
     */
    public function getUrlCode();
    /**
     * @return string
     */
    public function getDatabaseCode();
    /**
     * @return string
     */
    public function getFlag();
    /**
     * @return string
     */
    public function getNativeName();

    /**
     * Must be return flag value
     * If Current is not null need a set flag to this value
     * @param bool|null $current
     * @return bool
     */
    public function isCurrent($current = null);
}