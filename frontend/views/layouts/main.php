<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="author" content="WYLE.studio | https://wyle.studio">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, max-scale=2">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" sizes="180x180" href="/static/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/static/img/icons/favicon-16x16.png">
    <link rel="manifest" href="/static/img/icons/site.webmanifest">
    <link rel="mask-icon" href="/static/img/icons/safari-pinned-tab.svg" color="#192eaa">
    <link rel="shortcut icon" href="/static/img/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#192eaa">
    <meta name="msapplication-TileImage" content="/static/img/icons/mstile-144x144.png">
    <meta name="msapplication-config" content="/static/img/icons/browserconfig.xml">
    <meta name="theme-color" content="#192eaa">

    <!-- OPEN GRAPH -->
  
    <meta property="og:site_name" content="LeoIkea — Доставка з IKEA" />
    <meta property="og:title" content="<?= Html::encode($this->title) ?>" />
    <meta property="og:locale" content="<?= Yii::$app->language ?>">    
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?='https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']?>" />
    <meta property="og:image" content="/static/img/icons/apple-touch-icon.png" />

    <!-- OPEN GRAPH - END -->

    <?php $this->head() ?>
    <meta name="referrer" content="origin">
</head>
<body>
<?php $this->beginBody() ?>
<div id="app">
    <?= $this->render('parts/header') ?>
    <main class="site_main" id="site_main">
        <?= $content ?>
    </main>
    <?= $this->render('parts/footer') ?>
    <?= $this->render('parts/v-modals') ?>
</div>
<?= $this->render('parts/modals') ?>

<?php $this->endBody() ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-142259808-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-142259808-1');
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '353791068615877');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=353791068615877&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v3.3'
    });
  };

  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/ru_RU/sdk/xfbml.customerchat.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="1798394557068844"
  theme_color="#0b2daa"
  logged_in_greeting="Привіт, це LeoIkea! Чим можу бути вам корисним?"
  logged_out_greeting="Привіт, це LeoIkea! Чим можу бути вам корисним?">
</div>

</body>
</html>
<?php $this->endPage() ?>