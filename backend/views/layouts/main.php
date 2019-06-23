<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use metronic\Metronic;

$assetsBundle = Metronic::registerThemeAsset($this);
$this->registerJs("window.MetronicBaseUrl='$assetsBundle->baseUrl';", \yii\web\View::POS_HEAD);

$headTitle = isset($this->params['headTitle']) ? $this->params['headTitle'] : $this->title;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!-- begin::Head -->
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= Html::encode(Yii::$app->name . ' | ' . $headTitle) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Open Sans:300,400,500,600,700:cyrillic"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Global Theme Styles -->
    <?php $this->head() ?>
    <!--end::Global Theme Styles -->
    <link rel="shortcut icon" href="/favicon.ico"/>
</head>
<!-- end::Head -->
<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<?= $this->beginBody() ?>
<div class="m-grid m-grid--hor m-grid--root m-page">

    <!-- BEGIN: Header -->
    <?= $this->render('parts/header', ['assetsBundle' => $assetsBundle]) ?>
    <!-- END: Header -->

    <!-- begin::Body -->
    <?= $this->render('parts/content', ['assetsBundle' => $assetsBundle, 'content' => $content]) ?>
    <!-- end:: Body -->

    <!-- begin::Footer -->
    <?= $this->render('parts/footer', ['assetsBundle' => $assetsBundle]) ?>
    <!-- end::Footer -->
</div>

<!-- end:: Page -->

<!-- begin::Quick Sidebar -->
<?= $this->render('parts/quick-sidebar', ['assetsBundle' => $assetsBundle]) ?>
<!-- end::Quick Sidebar -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<!--begin::Global Theme Bundle -->
<?php $this->endBody() ?>
<!--end::Global Theme Bundle -->
</body>
<!-- end::Body -->
</html>
<?= $this->endPage() ?>