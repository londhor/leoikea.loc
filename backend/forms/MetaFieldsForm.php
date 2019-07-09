<?php

namespace backend\forms;

use yii;
use yii\base\Model;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

class MetaFieldsForm extends Model
{
    const SETTINGS_SECTION = 'metaFields';

    /**
     * @var string
     */
    public $homeTitle;
    /**
     * @var string
     */
    public $homeDescription;
    /**
     * @var string
     */
    public $catalogTitle;
    /**
     * @var string
     */
    public $catalogDescription;
    /**
     * @var string
     */
    public $searchTitle;
    /**
     * @var string
     */
    public $searchDescription;
    /**
     * @var string
     */
    public $categoryTitle;
    /**
     * @var string
     */
    public $categoryDescription;
    /**
     * @var string
     */
    public $productTitle;
    /**
     * @var string
     */
    public $productDescription;
    /**
     * @var string
     */
    public $informationTitle;
    /**
     * @var string
     */
    public $informationDescription;
    /**
     * @var string
     */
    public $contactsTitle;
    /**
     * @var string
     */
    public $contactsDescription;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->homeTitle = (string) $this->getSetting('homeTitle', '');
        $this->homeDescription = (string) $this->getSetting('homeDescription', '');
        $this->catalogTitle = (string) $this->getSetting('catalogTitle', '');
        $this->catalogDescription = (string) $this->getSetting('catalogDescription', '');
        $this->searchTitle = (string) $this->getSetting('searchTitle', '');
        $this->searchDescription = (string) $this->getSetting('searchDescription', '');
        $this->categoryTitle = (string) $this->getSetting('categoryTitle', '');
        $this->categoryDescription = (string) $this->getSetting('categoryDescription', '');
        $this->productTitle = (string) $this->getSetting('productTitle', '');
        $this->productDescription = (string) $this->getSetting('productDescription', '');
        $this->informationTitle = (string) $this->getSetting('informationTitle', '');
        $this->informationDescription = (string) $this->getSetting('informationDescription', '');
        $this->contactsTitle = (string) $this->getSetting('contactsTitle', '');
        $this->contactsDescription = (string) $this->getSetting('contactsDescription', '');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'homeTitle', 'catalogTitle', 'searchTitle', 'categoryTitle',
                    'productTitle', 'informationTitle', 'contactsTitle'
                ],
                'string',
                'max' => 255,
            ],
            [
                [
                    'homeDescription', 'catalogDescription', 'searchDescription',
                    'categoryDescription', 'productDescription', 'informationDescription',
                    'contactsDescription'
                ],
                'string',
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
            'homeTitle' => 'Meta-title',
            'homeDescription' => 'Meta-description',
            'catalogTitle' => 'Meta-title',
            'catalogDescription' => 'Meta-description',
            'searchTitle' => 'Meta-title',
            'searchDescription' => 'Meta-description',
            'categoryTitle' => 'Meta-title',
            'categoryDescription' => 'Meta-description',
            'productTitle' => 'Meta-title',
            'productDescription' => 'Meta-description',
            'informationTitle' => 'Meta-title',
            'informationDescription' => 'Meta-description',
            'contactsTitle' => 'Meta-title',
            'contactsDescription' => 'Meta-description',
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

        $this->setSetting('homeTitle', $this->homeTitle, SettingType::STRING_TYPE);
        $this->setSetting('homeDescription', $this->homeDescription, SettingType::STRING_TYPE);
        $this->setSetting('catalogTitle', $this->catalogTitle, SettingType::STRING_TYPE);
        $this->setSetting('catalogDescription', $this->catalogDescription, SettingType::STRING_TYPE);
        $this->setSetting('searchTitle', $this->searchTitle, SettingType::STRING_TYPE);
        $this->setSetting('searchDescription', $this->searchDescription, SettingType::STRING_TYPE);
        $this->setSetting('categoryTitle', $this->categoryTitle, SettingType::STRING_TYPE);
        $this->setSetting('categoryDescription', $this->categoryDescription, SettingType::STRING_TYPE);
        $this->setSetting('productTitle', $this->productTitle, SettingType::STRING_TYPE);
        $this->setSetting('productDescription', $this->productDescription, SettingType::STRING_TYPE);
        $this->setSetting('informationTitle', $this->informationTitle, SettingType::STRING_TYPE);
        $this->setSetting('informationDescription', $this->informationDescription, SettingType::STRING_TYPE);
        $this->setSetting('contactsTitle', $this->contactsTitle, SettingType::STRING_TYPE);
        $this->setSetting('contactsDescription', $this->contactsDescription, SettingType::STRING_TYPE);

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