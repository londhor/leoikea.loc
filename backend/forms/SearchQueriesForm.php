<?php

namespace backend\forms;

use yii;
use yii\base\Model;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

class SearchQueriesForm extends Model
{
    const SETTINGS_SECTION = 'search_queries';
    const TYPE_JSON = 'json';

    /**
     * @var array
     */
    public $queries_ru;
    /**
     * @var array
     */
    public $queries_ua;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->queries_ru = (array) $this->getSetting('queries_ru', [], true);
        $this->queries_ua = (array) $this->getSetting('queries_ua', [], true);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['queries_ru', 'queries_ua'], 'validateQueries', 'skipOnEmpty' => false],
        ];
    }

    /**
     * @param string $attribute
     * @param array $params
     * @return bool
     */
    public function validateQueries($attribute, $params)
    {
        $validators = [
            'required' => new yii\validators\RequiredValidator([
                'message' => 'Заповніть запит'
            ]),
            'string' => new yii\validators\StringValidator([
                'max' => 45,
                'message' => $message = 'Заповніть пошуковий запит від 1 до 45 символів',
                'tooLong' => $message,
            ]),
        ];

        $filter = 'strip_tags';

        return $this->eachValidator($attribute, $validators, $filter);
    }

    /**
     * @param string $attribute
     * @param yii\validators\Validator[] $validators
     * @param \Closure|null $filter
     * @return bool
     */
    protected function eachValidator($attribute, $validators, $filter = null)
    {
        $list = $this->$attribute;

        if (!is_array($list)) {
            $this->$attribute = [];

            return true;
        }

        $valid = true;

        foreach ($list as $key => $value) {
            if (is_array($value) && isset($value[$attribute])) {
                $this->$attribute[$key] = $value = $value[$attribute];
            }

            if ($filter !== null && is_callable($filter)) {
                $this->$attribute[$key] = $value = call_user_func($filter, $value);
            }

            foreach ($validators as $validator) {
                $error = null;
                if (!$validator->validate($value, $error)) {
                    $this->addError($attribute . '.' . $key, $error);
                    $valid = false;
                }
            }
        }

        if (!$valid) {
            $this->addError($attribute, 'Введіть коректні дані');
        }

        return $valid;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'queries_ru' => 'Заптити [RU]',
            'queries_ua' => 'Заптити [UA]',
        ];
    }

    /**
     * @param bool $validate
     * @return bool
     */
    public function store($validate = true)
    {
        if ($validate && !$this->validate()) {
            return false;
        }

        $this->setSetting('queries_ru', $this->queries_ru, self::TYPE_JSON);
        $this->setSetting('queries_ua', $this->queries_ua, self::TYPE_JSON);

        return true;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @param bool $isJson
     * @return mixed
     */
    protected function getSetting($name, $default = null, $isJson = false)
    {
        $settings = Yii::$app->settings;
        $value = $settings->get(self::SETTINGS_SECTION, $name, $default);

        if ($isJson && is_string($value)) {
            $value = json_decode($value, true);
            if ($value === false) {
                $value = $default;
            }
        }

        return $value;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param string|null $type
     * @return bool
     */
    protected function setSetting($name, $value, $type = null)
    {
        /** @var Settings $settings */
        $settings = Yii::$app->settings;

        if ($type === self::TYPE_JSON) {
            $value = json_encode($value);
            $type = SettingType::STRING_TYPE;
        }

        return $settings->set(self::SETTINGS_SECTION, $name, $value, $type);
    }
}