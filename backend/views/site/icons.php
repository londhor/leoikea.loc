<?php

/* @var $this yii\web\View */

$this->title = 'Іконки';
$this->params['breadcrumbs'][] = $this->title;

use backend\assets\IconsAsset;
IconsAsset::register($this);

?>
<div class="row">
    <div class="col-md-12">
        <!--begin::Portlet-->
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                        <h3 class="m-portlet__head-text">Список усіх Іконок</h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <?php $index = 0 ?>
                    <?php foreach (IconsAsset::$icons as $icon => $name) { ?>
                        <div class="col-md-2">
                            <div class="m-demo-icon">
                                <div class="m-demo-icon__preview">
                                    <i class="<?= $icon ?>"></i>
                                </div>
                                <div class="m-demo-icon__class">
                                    <?= $name ?>
                                </div>
                            </div>
                        </div>
                        <?= ($index + 1) % 6 === 0 ? '<div class="m--clearfix"></div>' : '' ?>
                        <?php $index++ ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
</div>