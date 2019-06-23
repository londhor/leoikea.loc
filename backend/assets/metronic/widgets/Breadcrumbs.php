<?php

namespace metronic\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{
    public $options = [
        'class' => 'm-subheader__breadcrumbs m-nav m-nav--inline'
    ];

    public $homeLink = [
        'url' => ['site/index'],
        'template' => "<li class=\"m-nav__item m-nav__item--home\">{link}</li>\n",
        'label' => '<i class="m-nav__link-icon la la-home"></i>',
        'encode' => false,
        'class' => 'm-nav__link m-nav__link--icon',
        'labelTemplate' => '{label}',
    ];

    public $defaultLinkOptions = [
        'class' => 'm-nav__link',
    ];

    public $labelTemplate = '<span class="m-nav__link-text">{label}</span>';

    public $separator = "<li class=\"m-nav__separator\">-</li>\n";

    public $itemTemplate = "<li class=\"m-nav__item\">{link}</li>\n";

    public $activeItemTemplate = "<li class=\"m-nav__item active\">{link}</li>\n";

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }

        $links = [];

        if ($this->homeLink === null) {
            $links[] = $this->renderItem([
                'label' => Yii::t('yii', 'Home'),
                'url' => Yii::$app->homeUrl,
            ], $this->itemTemplate);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        echo Html::tag($this->tag, implode($this->separator, $links), $this->options);
    }

    /**
     * @inheritdoc
     */
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);

        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        $labelTemplate = ArrayHelper::remove($link, 'labelTemplate', $this->labelTemplate);

        $label = strtr($labelTemplate, ['{label}' => $label]);

        if (isset($link['url'])) {
            $options = ArrayHelper::merge($this->defaultLinkOptions, $link);

            unset($options['template'], $options['label'], $options['url']);

            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }
}
