<?php

namespace metronic\widgets;

use yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Menu extends yii\base\Widget
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * @var bool whether the labels for menu items should be HTML-encoded.
     */
    public $encodeLabels = true;

    /**
     * @var bool whether to automatically activate items according to whether their route setting
     * matches the currently requested route.
     * @see isItemActive()
     */
    public $activateItems = true;

    /**
     * @var bool whether to activate parent menu items when one of the corresponding child menu items is active.
     * The activated parent menu items will also have its CSS classes appended with [[activeCssClass]].
     */
    public $activateParents = false;

    /**
     * @var bool whether to hide empty menu items. An empty menu item is one whose `url` option is not
     * set and which has no visible child menu items.
     */
    public $hideEmptyItems = true;

    /**
     * @var array the HTML attributes for the menu's container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "ul", the tag name of the item container tags. Set to false to disable container tag.
     *   See also [[\yii\helpers\Html::tag()]].
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array
     */
    public $wrapOptions = [];

    /**
     * @var string the route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     * @see params
     * @see isItemActive()
     */
    public $route;

    /**
     * @var array the parameters used to determine if a menu item is active or not.
     * If not set, it will use `$_GET`.
     * @see route
     * @see isItemActive()
     */
    public $params;


    /**
     * Renders the menu.
     */
    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }

        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }

        $items = $this->normalizeItems($this->items, $hasActiveChild);

        if (!empty($items)) {
            $defaultWrapOptions = [
                'class' => ['m-aside-menu', 'm-aside-menu--skin-dark', 'm-aside-menu--submenu-skin-dark', 'm-scroller', 'ps', 'ps--active-y'],
                'id' => $this->id,
                'm-menu-vertical' => 1,
                'm-menu-scrollable' => 1,
                'm-menu-dropdown-timeout' => 500,
            ];
            $wrapOptions = ArrayHelper::merge($defaultWrapOptions, $this->wrapOptions);

            $defaultOptions = [
                'class' => ['m-menu__nav', 'm-menu__nav--dropdown-submenu-arrow'],
            ];
            $options = ArrayHelper::merge($defaultOptions, $this->options);

            $wrap = Html::tag(
                'div',
                Html::tag('ul', $this->renderItems($items), $options),
                $wrapOptions
            );

            echo $wrap;
        }
    }

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @param bool|false $isSubMenu
     * @return string the rendering result
     */
    protected function renderItems($items, $isSubMenu = false)
    {
        $lines = [];

        foreach ($items as $i => $item) {
            $default = ['aria-haspopup' => 'true', 'class' => ['m-menu__item']];
            $options = ArrayHelper::getValue($item, 'options', []);
            $class = [];

            if ($item['type'] === 'section') {
                Html::addCssClass($options, 'm-menu__section');
                $lines[] = Html::tag('li', $this->renderSection($item), $options);
                continue;
            }

            if ($item['active']) {
                $class[] = 'm-menu__item--active';
            }

            if (!empty($item['items'])) {
                $class[] = 'm-menu__item--submenu';
                $default['m-menu-submenu-toggle'] = 'hover';
            }

            if (!empty($item['items'])) {
                $template = "\n<div class=\"m-menu__submenu\"><span class=\"m-menu__arrow\"></span>\n" .
                    "<ul class=\"m-menu__subnav\">\n{items}\n</ul></div>\n";

                $subMenu = $this->renderParentItem($item);
                $subMenu .= "\n" . $this->renderItems($item['items'], true);

                $subMenu = strtr($template, [
                    '{items}' => $subMenu,
                ]);

                if ($item['activeChild']) {
                    $class[] = 'm-menu__item--open';
                    $class[] = 'm-menu__item--expanded';
                }
            } else {
                $subMenu = '';
            }

            Html::addCssClass($options, $class);
            $options = ArrayHelper::merge($default, $options);

            $menu = $this->renderItem($item, $isSubMenu);

            $lines[] = Html::tag('li', $menu . $subMenu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @param bool|false $isSubMenu
     * @return string the rendering result
     */
    protected function renderItem($item, $isSubMenu = false)
    {
        $options = ['class' => 'm-menu__link'];

        if (!empty($item['items'])) {
            Html::addCssClass($options, 'm-menu__toggle');
        }

        if ($item['badge']) {
            $titleTemplate = "<span class=\"m-menu__link-title\"><span class=\"m-menu__link-wrap\"><span class=\"m-menu__link-text\">{label}</span> \n" .
                "<span class=\"m-menu__link-badge\"><span class=\"m-badge m-badge--{type}\">{text}</span></span></span></span>";

            $title = strtr($titleTemplate, [
                '{label}' => $item['label'],
                '{type}' => $item['badge']['type'],
                '{text}' => Html::encode($item['badge']['text'])
            ]);
        } else {
            $titleTemplate = "<span class=\"m-menu__link-text\">{label}</span>";

            $title = strtr($titleTemplate, [
                '{label}' => $item['label']
            ]);
        }

        if ($isSubMenu) {
            $icon = '<i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>';
        } elseif ($item['icon']) {
            $icon = sprintf('<i class="m-menu__link-icon %s"></i>', $item['icon']);
        } else {
            $icon = '';
        }

        if (!empty($item['items'])) {
            $toggle = '<i class="m-menu__ver-arrow la la-angle-right"></i>';
        } else {
            $toggle = '';
        }

        if (isset($item['url'])) {
            return Html::a($icon . $title . $toggle, $item['url'], $options);
        }

        return Html::tag('span', $icon . $title . $toggle, $options);
    }

    protected function renderParentItem($item)
    {
        $template = "<li class=\"m-menu__item  m-menu__item--parent\" aria-haspopup=\"true\">" .
            "<span class=\"m-menu__link\"><span class=\"m-menu__link-text\">{label}</span></span>" .
            "</li>";

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

    /**
     * @param array $item
     * @return string
     */
    protected function renderSection($item)
    {
        $template = "<h4 class=\"m-menu__section-text\">{label}</h4>\n" .
            "<i class=\"m-menu__section-icon flaticon-more-v2\"></i>";

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

    /**
     * Normalizes the [[items]] property to remove invisible items and activate certain items.
     * @param array $items the items to be normalized.
     * @param bool $active whether there is an active child menu item.
     * @return array the normalized menu items
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }

            if (!isset($item['label'])) {
                $item['label'] = '';
            }

            if (isset($item['type']) && $item['type'] === 'section') {
                if (empty($item['label'])) {
                    unset($items[$i]);
                }

                $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
                $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];

                continue;
            }

            if (!isset($item['badge']) || $item['badge'] === null) {
                $item['badge'] = $items[$i]['badge'] = false;
            }

            //brand, metal, light, accent, focus, primary, success, info, warning, danger
            if (is_array($item['badge'])) {
                $items[$i]['badge'] = [
                    'type' => isset($item['badge']['type']) ? $item['badge']['type'] : 'metal',
                    'text' => isset($item['badge']['text']) ? $item['badge']['text'] : '',
                ];
            } elseif ($item['badge'] !== false) {
                $items[$i]['badge'] = [
                    'type' => 'metal',
                    'text' => $item['badge'],
                ];
            }

            if (!isset($item['icon']) || $item['icon'] === null) {
                $items[$i]['icon'] = false;
            }

            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $hasActiveChild = false;

            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }

                if (!empty($items[$i]['items']) && !isset($item['url'])) {
                    $items[$i]['url'] = 'javascript:;';
                }
            }

            if (!isset($item['active'])) {
                if ($this->activateParents && $hasActiveChild || $this->activateItems && $this->isItemActive($item)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active'] instanceof \Closure) {
                $active = $items[$i]['active'] = call_user_func($item['active'], $item, $hasActiveChild, $this->isItemActive($item), $this);
            } elseif ($item['active']) {
                $active = true;
            }

            $items[$i]['activeChild'] = $hasActiveChild;
        }

        return array_values($items);
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return bool whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = Yii::getAlias($item['url'][0]);
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
}