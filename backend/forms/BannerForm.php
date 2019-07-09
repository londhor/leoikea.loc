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
     * @var array
     */
    public $title;

    /**
     * @var array
     */
    public $description;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->title = (string) $this->getSetting('title', '');
        $this->description = (string) $this->getSetting('description', '');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'trim'],
            [['title', 'description'], 'filter',
                'filter' => 'strip_tags',
            ],
            [['title'], 'required'],
            [['title'], 'string',
                'min' => 2,
                'max' => 255,
            ],
            [['description'], 'string',
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
            'title' => 'Заголовок',
            'description' => 'Підзаголовок',
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

        $this->setSetting('title', $this->title, SettingType::STRING_TYPE);
        $this->setSetting('description', $this->description, SettingType::STRING_TYPE);

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