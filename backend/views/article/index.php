<?php

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Url;

$this->title = 'Статті';

$this->params['breadcrumbs'] = [
    ['label' => 'Список'],
];

\metronic\Metronic::registerJsFile($this, 'assets/snippets/pages/article/index.js');

?>
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    Статті
                    <small>Список статей</small>
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
                                                    <span class="m-nav__link-text">Створити</span>
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
        <!--begin: Search Form -->
        <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
            <div class="row align-items-center">
                <div class="col-xl-8 order-2 order-xl-1">
                    <div class="form-group m-form__group row align-items-center">
                        <div class="col-md-4">
                            <div class="m-form__group m-form__group--inline">
                                <div class="m-form__label">
                                    <label class="m-label m-label--single">Заголовок:</label>
                                </div>
                                <div class="m-form__control">
                                    <input type="text" class="form-control m-input" id="ArticleFilterTitle">
                                </div>
                            </div>
                            <div class="d-md-none m--margin-bottom-10"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                    <button class="btn btn-secondary m-btn m-btn--icon" id="ArticleTableReset">
                        <span><i class="la la-close"></i><span>Очистити</span></span>
                    </button>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
            </div>
        </div>
        <!--end: Search Form -->

        <!--begin: Datatable -->
        <div class="m_datatable">
            <table class="table table-striped- table-bordered table-hover table-checkable" id="ArticleIndexTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Аліас</th>
                    <th>Дата створення</th>
                    <th>Дата редагування</th>
                    <th>Функцій</th>
                </tr>
                </thead>
            </table>
        </div>
        <!--end: Datatable -->
    </div>
</div>
