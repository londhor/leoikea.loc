<?php

namespace backend\forms;

use yii;
use yii\base\Model;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

class MetaFieldsForm extends Model
{
    const SETTINGS_SECTION = 'metaFields';

    public $homeTitle_ru;
    public $homeDescription_ru;
    public $catalogTitle_ru;
    public $catalogDescription_ru;
    public $searchTitle_ru;
    public $searchDescription_ru;
    public $categoryTitle_ru;
    public $categoryDescription_ru;
    public $productTitle_ru;
    public $productDescription_ru;
    public $informationTitle_ru;
    public $informationDescription_ru;
    public $contactsTitle_ru;
    public $contactsDescription_ru;

    public $homeTitle_ua;
    public $homeDescription_ua;
    public $catalogTitle_ua;
    public $catalogDescription_ua;
    public $searchTitle_ua;
    public $searchDescription_ua;
    public $categoryTitle_ua;
    public $categoryDescription_ua;
    public $productTitle_ua;
    public $productDescription_ua;
    public $informationTitle_ua;
    public $informationDescription_ua;
    public $contactsTitle_ua;
    public $contactsDescription_ua;

    /**
     * Load settings from component
     */
    public function init()
    {
        $this->homeTitle_ru = (string) $this->getSetting('homeTitle_ru', '');
        $this->homeDescription_ru = (string) $this->getSetting('homeDescription_ru', '');
        $this->catalogTitle_ru = (string) $this->getSetting('catalogTitle_ru', '');
        $this->catalogDescription_ru = (string) $this->getSetting('catalogDescription_ru', '');
        $this->searchTitle_ru = (string) $this->getSetting('searchTitle_ru', '');
        $this->searchDescription_ru = (string) $this->getSetting('searchDescription_ru', '');
        $this->categoryTitle_ru = (string) $this->getSetting('categoryTitle_ru', '');
        $this->categoryDescription_ru = (string) $this->getSetting('categoryDescription_ru', '');
        $this->productTitle_ru = (string) $this->getSetting('productTitle_ru', '');
        $this->productDescription_ru = (string) $this->getSetting('productDescription_ru', '');
        $this->informationTitle_ru = (string) $this->getSetting('informationTitle_ru', '');
        $this->informationDescription_ru = (string) $this->getSetting('informationDescription_ru', '');
        $this->contactsTitle_ru = (string) $this->getSetting('contactsTitle_ru', '');
        $this->contactsDescription_ru = (string) $this->getSetting('contactsDescription_ru', '');

        $this->homeTitle_ua = (string) $this->getSetting('homeTitle_ua', '');
        $this->homeDescription_ua = (string) $this->getSetting('homeDescription_ua', '');
        $this->catalogTitle_ua = (string) $this->getSetting('catalogTitle_ua', '');
        $this->catalogDescription_ua = (string) $this->getSetting('catalogDescription_ua', '');
        $this->searchTitle_ua = (string) $this->getSetting('searchTitle_ua', '');
        $this->searchDescription_ua = (string) $this->getSetting('searchDescription_ua', '');
        $this->categoryTitle_ua = (string) $this->getSetting('categoryTitle_ua', '');
        $this->categoryDescription_ua = (string) $this->getSetting('categoryDescription_ua', '');
        $this->productTitle_ua = (string) $this->getSetting('productTitle_ua', '');
        $this->productDescription_ua = (string) $this->getSetting('productDescription_ua', '');
        $this->informationTitle_ua = (string) $this->getSetting('informationTitle_ua', '');
        $this->informationDescription_ua = (string) $this->getSetting('informationDescription_ua', '');
        $this->contactsTitle_ua = (string) $this->getSetting('contactsTitle_ua', '');
        $this->contactsDescription_ua = (string) $this->getSetting('contactsDescription_ua', '');
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'homeTitle_ru', 'catalogTitle_ru', 'searchTitle_ru', 'categoryTitle_ru',
                    'productTitle_ru', 'informationTitle_ru', 'contactsTitle_ru',
                    'homeTitle_ua', 'catalogTitle_ua', 'searchTitle_ua', 'categoryTitle_ua',
                    'productTitle_ua', 'informationTitle_ua', 'contactsTitle_ua',
                ],
                'string',
                'max' => 255,
            ],
            [
                [
                    'homeDescription_ru', 'catalogDescription_ru', 'searchDescription_ru',
                    'categoryDescription_ru', 'productDescription_ru', 'informationDescription_ru',
                    'contactsDescription_ru',
                    'homeDescription_ua', 'catalogDescription_ua', 'searchDescription_ua',
                    'categoryDescription_ua', 'productDescription_ua', 'informationDescription_ua',
                    'contactsDescription_ua',
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
            'homeTitle_ru'              => 'Meta-title',
            'homeDescription_ru'        => 'Meta-description',
            'catalogTitle_ru'           => 'Meta-title',
            'catalogDescription_ru'     => 'Meta-description',
            'searchTitle_ru'            => 'Meta-title',
            'searchDescription_ru'      => 'Meta-description',
            'categoryTitle_ru'          => 'Meta-title',
            'categoryDescription_ru'    => 'Meta-description',
            'productTitle_ru'           => 'Meta-title',
            'productDescription_ru'     => 'Meta-description',
            'informationTitle_ru'       => 'Meta-title',
            'informationDescription_ru' => 'Meta-description',
            'contactsTitle_ru'          => 'Meta-title',
            'contactsDescription_ru'    => 'Meta-description',

            'homeTitle_ua'              => 'Meta-title',
            'homeDescription_ua'        => 'Meta-description',
            'catalogTitle_ua'           => 'Meta-title',
            'catalogDescription_ua'     => 'Meta-description',
            'searchTitle_ua'            => 'Meta-title',
            'searchDescription_ua'      => 'Meta-description',
            'categoryTitle_ua'          => 'Meta-title',
            'categoryDescription_ua'    => 'Meta-description',
            'productTitle_ua'           => 'Meta-title',
            'productDescription_ua'     => 'Meta-description',
            'informationTitle_ua'       => 'Meta-title',
            'informationDescription_ua' => 'Meta-description',
            'contactsTitle_ua'          => 'Meta-title',
            'contactsDescription_ua'    => 'Meta-description',
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

        $this->setSetting('homeTitle_ru', $this->homeTitle_ru, SettingType::STRING_TYPE);
        $this->setSetting('homeDescription_ru', $this->homeDescription_ru, SettingType::STRING_TYPE);
        $this->setSetting('catalogTitle_ru', $this->catalogTitle_ru, SettingType::STRING_TYPE);
        $this->setSetting('catalogDescription_ru', $this->catalogDescription_ru, SettingType::STRING_TYPE);
        $this->setSetting('searchTitle_ru', $this->searchTitle_ru, SettingType::STRING_TYPE);
        $this->setSetting('searchDescription_ru', $this->searchDescription_ru, SettingType::STRING_TYPE);
        $this->setSetting('categoryTitle_ru', $this->categoryTitle_ru, SettingType::STRING_TYPE);
        $this->setSetting('categoryDescription_ru', $this->categoryDescription_ru, SettingType::STRING_TYPE);
        $this->setSetting('productTitle_ru', $this->productTitle_ru, SettingType::STRING_TYPE);
        $this->setSetting('productDescription_ru', $this->productDescription_ru, SettingType::STRING_TYPE);
        $this->setSetting('informationTitle_ru', $this->informationTitle_ru, SettingType::STRING_TYPE);
        $this->setSetting('informationDescription_ru', $this->informationDescription_ru, SettingType::STRING_TYPE);
        $this->setSetting('contactsTitle_ru', $this->contactsTitle_ru, SettingType::STRING_TYPE);
        $this->setSetting('contactsDescription_ru', $this->contactsDescription_ru, SettingType::STRING_TYPE);

        $this->setSetting('homeTitle_ua', $this->homeTitle_ua, SettingType::STRING_TYPE);
        $this->setSetting('homeDescription_ua', $this->homeDescription_ua, SettingType::STRING_TYPE);
        $this->setSetting('catalogTitle_ua', $this->catalogTitle_ua, SettingType::STRING_TYPE);
        $this->setSetting('catalogDescription_ua', $this->catalogDescription_ua, SettingType::STRING_TYPE);
        $this->setSetting('searchTitle_ua', $this->searchTitle_ua, SettingType::STRING_TYPE);
        $this->setSetting('searchDescription_ua', $this->searchDescription_ua, SettingType::STRING_TYPE);
        $this->setSetting('categoryTitle_ua', $this->categoryTitle_ua, SettingType::STRING_TYPE);
        $this->setSetting('categoryDescription_ua', $this->categoryDescription_ua, SettingType::STRING_TYPE);
        $this->setSetting('productTitle_ua', $this->productTitle_ua, SettingType::STRING_TYPE);
        $this->setSetting('productDescription_ua', $this->productDescription_ua, SettingType::STRING_TYPE);
        $this->setSetting('informationTitle_ua', $this->informationTitle_ua, SettingType::STRING_TYPE);
        $this->setSetting('informationDescription_ua', $this->informationDescription_ua, SettingType::STRING_TYPE);
        $this->setSetting('contactsTitle_ua', $this->contactsTitle_ua, SettingType::STRING_TYPE);
        $this->setSetting('contactsDescription_ua', $this->contactsDescription_ua, SettingType::STRING_TYPE);

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