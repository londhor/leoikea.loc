<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Url;

$this->title = 'Нам довіряють';

$this->params['breadcrumbs'] = [
    ['label' => 'Контент блоки'],
    ['label' => 'Нам довіряють']
];

\metronic\Metronic::registerJsFile($this, 'assets/snippets/pages/our-clients/index.js');

?>
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Нам довіряють
                    <small>Список</small>
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                         m-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#"
                           class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                            <i class="la la-ellipsis-h m--font-brand"></i>
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav">
                                            <li class="m-nav__section m-nav__section--first">
                                                <span class="m-nav__section-text">Функції</span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="<?= Url::to(['update']) ?>" class="m-nav__link">
                                                    <i class="m-nav__link-icon la la-user-plus"></i>
                                                    <span class="m-nav__link-text">Додати</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <!--begin: Datatable -->
        <div class="m_datatable">
            <table class="table table-striped- table-bordered table-hover table-checkable" id="OurClientsIndexTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Зображення</th>
                    <th>Порядок</th>
                    <th>Функцій</th>
                </tr>
                </thead>
            </table>
        </div>
        <!--end: Datatable -->
    </div>
</div>
