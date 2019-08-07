<?php

namespace frontend\components\multilang;

use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Languages component
 * @package frontend\components\multilang
 */
class Languages extends Component
{
    /**
     * @var LanguageInterface[]
     */
    protected $languages;
    /**
     * @var LanguageInterface|null
     */
    protected $current;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->languages === null) {
            throw new InvalidConfigException('Languages must be configured');
        }
    }

    /**
     * @param array|LanguageInterface[] $languages
     * @throws InvalidConfigException
     */
    public function setLanguages($languages)
    {
        if (!is_array($languages)) {
            throw new InvalidConfigException('Languages must be an array');
        }

        foreach ($languages as $language) {
            $this->addLanguage($language);
        }
    }
    /**
     * @return LanguageInterface[]
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param array|LanguageInterface $language
     * @throws InvalidConfigException
     */
    public function addLanguage($language)
    {
        if (is_array($language)) {
            if (!isset($language['class'])) {
                $language['class'] = Language::class;
            }
            $language = Yii::createObject($language);
        }

        if (!$language instanceof LanguageInterface) {
            throw new InvalidConfigException('Language must be instanceof LanguageInterface');
        }

        try {
            $this->validateLanguage($language);
        } catch (InvalidConfigException $exception) {
            throw $exception;
        }

        $this->languages[$language->getUrlCode()] = $language;

        if ($language->isCurrent()) {
            $this->current = $language;
        }
    }

    /**
     * @param string $urlCode
     * @return LanguageInterface|null
     */
    public function get($urlCode)
    {
        if (isset($this->languages[$urlCode])) {
            return $this->languages[$urlCode];
        }

        return null;
    }

    /**
     * @param LanguageInterface $language
     */
    public function setCurrent($language)
    {
        foreach ($this->languages as $languageItem) {
            $languageItem->isCurrent(false);
        }

        $language->isCurrent(true);
        $this->current = $language;
    }

    /**
     * @return LanguageInterface|null
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param LanguageInterface $language
     * @throws InvalidConfigException
     */
    protected function validateLanguage($language)
    {
        if ($language->getCode() === null) {
            throw new InvalidConfigException('Code for Language can\'t empty');
        }

        if ($language->getUrlCode() === null) {
            throw new InvalidConfigException('Url code for Language can\'t empty');
        }

        if ($language->getDatabaseCode() === null) {
            throw new InvalidConfigException('Database code for Language can\'t empty');
        }

        if ($language->getNativeName() === null) {
            throw new InvalidConfigException('Native name for Language can\'t empty');
        }

        if ($language->getFlag() === null) {
            throw new InvalidConfigException('Flag icon for Language can\'t empty');
        }
    }
}