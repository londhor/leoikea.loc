<?php

/* @var $this \yii\web\View */
/* @var $class string */
/* @var $icon string */
/* @var $message string */

$wrapClass = 'm-alert m-alert--air m-alert--square alert alert-dismissible fade show';

if ($icon) {
    $wrapClass .= ' m-alert--icon';
}

if ($class) {
    $wrapClass .= ' ' . $class;
}

?>
<div class="<?= $wrapClass ?>" role="alert">
    <?php if ($icon) { ?>
        <div class="m-alert__icon">
            <i class="<?= $icon ?>"></i>
        </div>
    <?php } ?>
    <div class="m-alert__text">
        <?= $message ?>
    </div>
    <div class="m-alert__close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
    </div>
</div>