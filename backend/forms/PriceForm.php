<?php

namespace backend\forms;

use yii;
use yii\base\Model;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

class PriceForm extends Model
{
    const SETTINGS_SECTION = 'price';

    /**
     * @var array
     */
    public $currencyRate;

    /**
     * @var array
     */
    public $discountPercent;

    /**
     * @var array
     */
    public $discountDescription;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->currencyRate = (string) $this->getSetting('currencyRate', '');
        $this->discountPercent = (string) $this->getSetting('discountPercent', '');
        $this->discountDescription = (string) $this->getSetting('discountDescription', '');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['currencyRate'], 'required'],
            [['discountDescription'], 'filter',
                'filter' => 'strip_tags',
            ],
            [['currencyRate'], 'number',
                'min' => 1e-5,
            ],
            [['discountPercent'], 'number',
                'min' => 0,
                'max' => 99,
            ],
            [['discountDescription'], 'string',
                'min' => 0,
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
            'currencyRate' => 'Коефіцієнт ціни',
            'discountPercent' => 'Акційна пропозиція',
            'discountDescription' => 'Акційний текст',
        ];
    }

    /**
     * @return array
     */
    public function attributeHints()
    {
        return [
            'discountPercent' => 'Відсоток знижки (якщо 5, тоді знижка 5%)',
            'discountDescription' => 'Замість {{discount}} підставиться відсоток знижки',
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

        $this->setSetting('currencyRate', $this->currencyRate, SettingType::FLOAT_TYPE);
        $this->setSetting('discountPercent', $this->discountPercent, SettingType::FLOAT_TYPE);
        $this->setSetting('discountDescription', $this->discountDescription, SettingType::STRING_TYPE);

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