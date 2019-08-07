<?php

namespace backend\forms;

use yii;
use yii\base\Model;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

class BannerForm extends Model
{
    const SETTINGS_SECTION = 'banner';

    /**
     * @var string
     */
    public $title_ru;
    /**
     * @var string
     */
    public $title_ua;
    /**
     * @var string
     */
    public $description_ru;
    /**
     * @var string
     */
    public $description_ua;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->title_ru = (string) $this->getSetting('title_ru', '');
        $this->title_ua = (string) $this->getSetting('title_ua', '');
        $this->description_ru = (string) $this->getSetting('description_ru', '');
        $this->description_ua = (string) $this->getSetting('description_ua', '');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title_ru', 'description_ru', 'title_ua', 'description_ua'], 'trim'],
            [['title_ru', 'description_ru', 'title_ua', 'description_ua'], 'filter',
                'filter' => 'strip_tags',
            ],
            [['title_ru', 'title_ua'], 'required'],
            [['title_ru', 'title_ua'], 'string',
                'min' => 2,
                'max' => 255,
            ],
            [['description_ru', 'description_ua'], 'string',
                'min' => 2,
                'max' => 500,
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title_ru' => 'Заголовок [RU]',
            'title_ua' => 'Заголовок [UA]',
            'description_ru' => 'Підзаголовок [RU]',
            'description_ua' => 'Підзаголовок [UA]',
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

        $this->setSetting('title_ru', $this->title_ru, SettingType::STRING_TYPE);
        $this->setSetting('title_ua', $this->title_ua, SettingType::STRING_TYPE);
        $this->setSetting('description_ru', $this->description_ru, SettingType::STRING_TYPE);
        $this->setSetting('description_ua', $this->description_ua, SettingType::STRING_TYPE);

        return true;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    protected function getSetting($name, $default = null)
    {
        $settings = Yii::$app->settings;
        return $settings->get(self::SETTINGS_SECTION, $name, $default);
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

        if ($value === '' || $value === null) {
            return $settings->remove(self::SETTINGS_SECTION, $name);
        }

        return $settings->set(self::SETTINGS_SECTION, $name, $value, $type);
    }
}