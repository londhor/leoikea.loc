<?php

namespace frontend\components\multilang;

use yii;
use yii\base\Behavior;

/**
 * Language attribute behavior
 * @package frontend\components\multilang
 */
class AttributeBehavior extends Behavior
{
    /**
     * @var yii\db\ActiveRecord
     */
    public $owner;

    /**
     * @var array
     */
    public $attributes = [];

    /**
     * Get language attribute value
     * @param string $attribute
     * @return mixed
     */
    public function lang($attribute)
    {
        $langAttribute = $this->getLangAttributeName($attribute);
        if ($langAttribute === null) {
            return null;
        }

        $result = null;
        if ($this->owner->hasAttribute($langAttribute)) {
            $result = $this->owner->getAttribute($langAttribute);
        }

        if ($result === null
            && isset($this->attributes[$attribute], $this->attributes[$attribute]['default'])
            && $this->owner->hasAttribute($this->attributes[$attribute]['default'])
        ) {
            $result = $this->owner->getAttribute($this->attributes[$attribute]['default']);
        }

        return $result;
    }

    /**
     * @param string $attribute
     * @param LanguageInterface $language
     * @return mixed|null
     */
    public function getLangAttributeName($attribute, $language = null)
    {
        if (!isset($this->attributes[$attribute])) {
            return $attribute;
        }

        $params = $this->attributes[$attribute];

        if ($language === null) {
            $language = $this->component()->getCurrent();
        }

        if ($language === null) {
            return isset($params['default']) ? $params['default'] : null;
        }

        if (isset($params['override'], $params['override'][$language->getCode()])) {
            return $params['override'][$language->getCode()];
        }

        if (isset($params['template'])) {
            return strtr($params['template'], [
                '{{code}}' => $language->getDatabaseCode(),
            ]);
        }

        return $attribute;
    }

    /**
     * @return Languages
     */
    protected function component()
    {
        return Yii::$app->languages;
    }
}