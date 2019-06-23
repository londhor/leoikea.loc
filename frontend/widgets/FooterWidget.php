<?php

namespace frontend\widgets;

use yii\base\Widget;

/**
 * Footer widget
 * @package frontend\widgets
 */
class FooterWidget extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        if (!$this->showFooter()) {
            return '';
        }

        return $this->render('footer', [
            'footerArticles' => $this->articles(),
            'socialLinks' => $this->social(),
            'contacts' => $this->contacts(),
        ]);
    }

    /**
     * @return array
     */
    protected function contacts()
    {
        return [
            'addresses' => [
                ['address' => 'Вул. Івана Франка, 78<br>Львів, Львівська область']
            ],
            'phones' => [
                ['label' => '+380 (96) <span>550 20 05</span>', 'phone' => '+380965502005'],
                ['label' => '+380 (93) <span>434 50 73</span>', 'phone' => '+380934345073'],
                ['label' => '+380 (97) <span>580 80 60</span>', 'phone' => '+380975808060'],
            ],
            'emails' => [
                ['email' => 'ikeaikea211@gmail.com']
            ]
        ];
    }

    /**
     * @return array
     */
    protected function articles()
    {
        return [
            [
                'label' => 'Политика конфиденциальности',
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
    }

    /**
     * @return array
     */
    protected function social()
    {
        return [
            [
                'label' => 'Фейсбук',
                'icon' => 'ic-facebook',
                'url' => 'https://www.facebook.com',
            ],
            [
                'label' => 'Інстаграм',
                'icon' => 'ic-instagram',
                'url' => 'https://instagram.com',
            ],
        ];
    }

    /**
     * @return bool
     */
    protected function showFooter()
    {
        if (!isset($this->view->params['hideFooter'])) {
            return true;
        }

        if ($this->view->params['hideFooter'] !== true) {
            return true;
        }

        return false;
    }
}