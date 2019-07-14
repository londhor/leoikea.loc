<?php

/* @var $this yii\web\View */

?>
<?= \frontend\widgets\FooterWidget::widget() ?>
<div class="copyright">
    <div class="container copyright-container">
        <div class="copyright-text"><?= Yii::t('app', '&copy; {year} {siteName} — Доставка товарів з Ikea', [
            'year' => date('Y'),
            'siteName' => Yii::$app->name
        ]) ?></div>
    </div>
</div>