<?php

namespace frontend\components;

use yii;
use yii2mod\settings\components\Settings;
use yii2mod\settings\models\enumerables\SettingType;

/**
 * Class ContentSettings
 */
class ContentSettings extends \yii\base\Component
{
    const CONTACTS_SECTION = 'contacts';
    const ADVANTAGES_SECTION = 'advantages';
    const SEARCH_QUERIES_SECTION = 'search_queries';
    const BANNER_SECTION = 'banner';

    /**
     * @var array|null
     */
    protected $_addresses;

    /**
     * @var array|null
     */
    protected $_emails;

    /**
     * @var array|null
     */
    protected $_phones;

    /**
     * @var array|null
     */
    protected $_socials;

    /**
     * @var array|null
     */
    protected $_advantages;

    /**
     * @var array|null
     */
    protected $_searchQueries;

    /**
     * @var array|null
     */
    protected $_footerArticles;

    /**
     * @var array|null
     */
    protected $_banner;

    /**
     * @return array
     */
    public function getEmails()
    {
        if ($this->_emails !== null) {
            return $this->_emails;
        }

        $list = $this->getSetting(self::CONTACTS_SECTION, 'email', []);
        $this->_emails = [];

        foreach ($list as $email) {
            $this->_emails[] = [
                'email' => $email,
            ];
        }

        return $this->_emails;
    }

    /**
     * @return array
     */
    public function getPhones()
    {
        if ($this->_phones !== null) {
            return $this->_phones;
        }

        $list = $this->getSetting(self::CONTACTS_SECTION, 'phone', []);
        $this->_phones = [];

        foreach ($list as $phone) {
            $label = preg_replace('/\D+/i', '', $phone);

            if (preg_match('/^(380)(\d{2})(\d{3})(\d{2})(\d{2})$/i', $label, $digits)) {
                $label = vsprintf('+%s (%s) <span>%s %s %s</span>', array_slice($digits, 1));
            } else {
                $label = $phone;
            }

            $this->_phones[] = [
                'phone' => $phone,
                'label' => $label,
            ];
        }

        return $this->_phones;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        if ($this->_addresses !== null) {
            return $this->_addresses;
        }

        $list = $this->getSetting(self::CONTACTS_SECTION, 'address', []);
        $this->_addresses = [];

        foreach ($list as $item) {
            $this->_addresses[] = [
                'address' => nl2br($item)
            ];
        }

        return $this->_addresses;
    }

    /**
     * @return array|null
     */
    public function getSocials()
    {
        if ($this->_socials !== null) {
            return $this->_socials;
        }

        $list = $this->getSetting(self::CONTACTS_SECTION, 'social', []);
        $this->_socials = [];

        foreach ($list as $item) {
            $this->_socials[] = [
                'url' => (string) $item['link'],
                'label' => (string) $item['label'],
                'icon' => (string) $item['icon'],
            ];
        }

        return $this->_socials;
    }

    /**
     * @return array|null
     */
    public function getAdvantages()
    {
        if ($this->_advantages !== null) {
            return $this->_advantages;
        }

        $list = $this->getSetting(self::ADVANTAGES_SECTION, 'advantages', []);
        $this->_advantages = [];

        foreach ($list as $item) {
            $this->_advantages[] = [
                'label' => (string) $item['label'],
                'icon' => (string) $item['icon'],
            ];
        }

        return $this->_advantages;
    }

    /**
     * @return array|null
     */
    public function getSearchQueries()
    {
        if ($this->_searchQueries !== null) {
            return $this->_searchQueries;
        }

        $list = $this->getSetting(self::SEARCH_QUERIES_SECTION, 'queries', []);
        $this->_searchQueries = [];

        foreach ($list as $item) {
            $this->_searchQueries[] = [
                'query' => (string) $item
            ];
        }

        return $this->_searchQueries;
    }

    /**
     * @return array|null
     */
    public function getFooterArticles()
    {
        if ($this->_footerArticles !== null) {
            return $this->_footerArticles;
        }

        $this->_footerArticles = [
            [
                'label' => 'Політика конфіденційності',
                'url' => ['/article/view', 'key' => 'privacy-policy'],
            ],
            [
                'label' => 'Доставка та оплата',
                'url' => ['/article/view', 'key' => 'payment-and-delivery'],
            ],
            [
                'label' => 'Питання та відповіді',
                'url' => ['/article/view', 'key' => 'faq'],
            ],
        ];

        return $this->_footerArticles;
    }

    /**
     * @return string|null
     */
    public function getReviewsLink()
    {
        return $this->settings()->get(self::CONTACTS_SECTION, 'reviewsLink', null);
    }

    /**
     * @return array|null
     */
    public function getBanner()
    {
        if ($this->_banner !== null) {
            return $this->_banner;
        }

        $this->_banner = [
            'title' => nl2br((string) $this->settings()->get(self::BANNER_SECTION, 'title', null)),
            'description' => nl2br((string) $this->settings()->get(self::BANNER_SECTION, 'description', null)),
        ];

        return $this->_banner;
    }

    /**
     * @param string $section
     * @param string $key
     * @param mixed|null $default
     * @return array|null
     */
    protected function getSetting($section, $key, $default = null)
    {
        $value = $this->settings()->get($section, $key, $default);

        if (is_string($value)) {
            $value = json_decode($value, true);

            if (is_array($value)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * @return Settings
     */
    protected function settings()
    {
        return Yii::$app->settings;
    }
}