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
$color = "#0B2EAA";

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="author" content="David Devero | londhor | https://londhor.com">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="ya-dock" content="<?= $color ?>">
    <meta name="ya-title" content="<?= $color ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="/static/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/static/img/icons/favicon-16x16.png">
    <link rel="manifest" href="/static/img/icons/manifest.json">
    <link rel="mask-icon" href="/static/img/icons/safari-pinned-tab.svg" color="<?= $color ?>">
    <link rel="shortcut icon" href="/static/img/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="<?= $color ?>">
    <meta name="msapplication-TileImage" content="/static/img/icons/mstile-144x144.png">
    <meta name="msapplication-config" content="/static/img/icons/browserconfig.xml">
    <meta name="theme-color" content="<?= $color ?>">
    <?php $this->head() ?>
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
<?php

$this->registerJs(<<<JS
    try {
        var swiper = new Swiper('.our-clients-slider', {
            slidesPerView: 7,
            slidesPerColumn: 2,
            spaceBetween: 16,
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            breakpoints: {
                1400: {
                    slidesPerView: 6,
                    spaceBetween: 10,
                },
                980: {
                    slidesPerView: 4,
                    spaceBetween: 8,
                },
                420: {
                    slidesPerView: 2,
                    spaceBetween: 8,
                },
            },
        });
    } catch {
        console.log('.our-clients-slider is empty');
    }
    
    try {
        var swiper = new Swiper('.feedback-slider', {
            slidesPerView: 'auto',
            // centeredSlides: false,
            spaceBetween: 10,
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            breakpoints: {
                980: {
                    // slidesPerView: 3,
                    // centeredSlides: true,
                },
                420: {
                    // slidesPerView: 1,
                    // centeredSlides: true,
                },
            },
        });
    } catch {
        console.log('.feedback-slider is empty');
    }
    
    var itemSlirers = document.querySelectorAll('.items-slider');
    if (itemSlirers) {
        for (slider in itemSlirers) {
            try {
                new Swiper(itemSlirers[slider], {
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    pagination: {
                      el: '.swiper-pagination',
                      clickable: true,
                    },
                });
            } catch {
                console.warn('.items-slider is empty');
            }
        }
    }
    
    try {
        var siThumbs = new Swiper('.si-thumbs', {
            spaceBetween: 8,
            slidesPerView: 'auto',
            watchSlidesVisibility: true,
        });
    
        var swiper = new Swiper('.si-slider', {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 5,
            thumbs: {
                swiper: siThumbs,
            },
        });
    } catch {
        console.log('.feedback-slider is empty');
    }
JS
, \yii\web\View::POS_END);

?>
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
  logged_in_greeting="Привіт, це LeoIkea! Чим можемо бути вам корисні?"
  logged_out_greeting="Привіт, це LeoIkea! Чим можемо бути вам корисні?">
</div>

</body>
</html>
<?php $this->endPage() ?>