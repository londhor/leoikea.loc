<?php

use yii\db\Migration;

/**
 * Class m190717_051318_rename_settings_fields
 */
class m190717_051318_rename_settings_fields extends Migration
{
    protected $settings = '{{%setting}}';

    protected $needUpdate = [
        'advantages' => [
            'advantages' => 'advantages_{{lang}}',
        ],
        'price' => [
            'discountDescription' => 'discountDescription_{{lang}}',
        ],
        'banner' => [
            'title' => 'title_{{lang}}',
            'description' => 'description_{{lang}}',
        ],
        'search_queries' => [
            'queries' => 'queries_{{lang}}',
        ],
        'contacts' => [
            'address' => 'address_{{lang}}',
        ],
        'metaFields' => [
            'homeTitle' => 'homeTitle_{{lang}}',
            'homeDescription' => 'homeDescription_{{lang}}',
            'catalogTitle' => 'catalogTitle_{{lang}}',
            'catalogDescription' => 'catalogDescription_{{lang}}',
            'searchTitle' => 'searchTitle_{{lang}}',
            'searchDescription' => 'searchDescription_{{lang}}',
            'categoryTitle' => 'categoryTitle_{{lang}}',
            'categoryDescription' => 'categoryDescription_{{lang}}',
            'productTitle' => 'productTitle_{{lang}}',
            'productDescription' => 'productDescription_{{lang}}',
            'contactsTitle' => 'contactsTitle_{{lang}}',
            'contactsDescription' => 'contactsDescription_{{lang}}',
            'informationTitle' => 'informationTitle_{{lang}}',
            'informationDescription' => 'informationDescription_{{lang}}',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $query = new \yii\db\Query();
        $settings = $query->select('*')
            ->from($this->settings)
            ->all();

        foreach ($settings as $setting) {
            if (!isset($this->needUpdate[$setting['section']])) {
                continue;
            }

            if (!isset($this->needUpdate[$setting['section']][$setting['key']])) {
                continue;
            }

            $newKey = $this->needUpdate[$setting['section']][$setting['key']];

            foreach ($this->languages() as $lang => $current) {
                if ($current) {
                    $this->update($this->settings, [
                        'key' => strtr($newKey, ['{{lang}}' => $lang]),
                    ], ['id' => $setting['id']]);
                } else {
                    unset($setting['id']);
                    $setting['key'] = strtr($newKey, ['{{lang}}' => $lang]);
                    $this->insert($this->settings, $setting);
                }
            }
        }

        $this->flushCache();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $query = new \yii\db\Query();
        $settings = $query->select('*')
            ->from($this->settings)
            ->all();

        $languages = $this->languages();
        $needUpdate = [];

        foreach ($this->needUpdate as $section => $keys) {
            $needUpdate[$section] = [];

            foreach ($keys as $key => $langKey) {
                foreach ($languages as $lang => $current) {
                    $newKey = strtr($langKey, ['{{lang}}' => $lang]);
                    $needUpdate[$section][$newKey] = $current ? $key : false;
                }
            }
        }

        foreach ($settings as $setting) {
            if (!isset($needUpdate[$setting['section']])) {
                continue;
            }

            if (!isset($needUpdate[$setting['section']][$setting['key']])) {
                continue;
            }

            $rule = $needUpdate[$setting['section']][$setting['key']];
            if ($rule === false) {
                $this->delete($this->settings, ['id' => $setting['id']]);
            } else {
                $this->update($this->settings, [
                    'key' => $rule,
                ], ['id' => $setting['id']]);
            }
        }

        $this->flushCache();
    }

    /**
     * @return array
     */
    protected function languages()
    {
        /** @var \frontend\components\multilang\LanguageInterface[] $languages */
        $languages = Yii::$app->languages->getLanguages();

        $result = [];
        foreach ($languages as $language) {
            if ($language->isCurrent()) {
                $result[$language->getDatabaseCode()] = true;
            } elseif (!isset($result[$language->getDatabaseCode()])) {
                $result[$language->getDatabaseCode()] = false;
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    protected function flushCache()
    {
        /** @var \yii2mod\settings\components\Settings $settings */
        $settings = Yii::$app->settings;
        return $settings->invalidateCache();
    }
}
